<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class StudentsImport implements 
    ToCollection, 
    WithHeadingRow, 
    SkipsEmptyRows
{
    public $imported = 0;
    public $skipped = 0;
    public $errors = [];

    public function collection(Collection $rows)
    {
        // ✅ DEBUG: Log first row to see column names
        if ($rows->isNotEmpty()) {
            $firstRow = $rows->first();
            Log::info('Excel Column Names', [
                'columns' => array_keys($firstRow->toArray()),
                'sample_data' => $firstRow->toArray()
            ]);
        }

        foreach ($rows as $index => $row) {
            try {
                // ✅ Log setiap row untuk debugging
                Log::info("Processing row " . ($index + 2), [
                    'data' => $row->toArray()
                ]);

                // ✅ Validasi NIM dengan berbagai kemungkinan nama kolom
                $nim = $this->getColumnValue($row, ['nim', 'NIM', 'No']);
                
                if (empty($nim)) {
                    $this->skipped++;
                    $this->errors[] = "Baris " . ($index + 2) . ": NIM tidak ditemukan. Kolom tersedia: " . implode(', ', array_keys($row->toArray()));
                    continue;
                }

                // ✅ Validasi Nama
                $nama = $this->getColumnValue($row, ['nama', 'Nama', 'NAMA']);
                
                if (empty($nama)) {
                    $this->skipped++;
                    $this->errors[] = "Baris " . ($index + 2) . ": Nama tidak ditemukan";
                    continue;
                }

                // Skip if NIM already exists
                if (Student::where('nim', $nim)->exists()) {
                    $this->skipped++;
                    $this->errors[] = "Baris " . ($index + 2) . ": NIM {$nim} sudah terdaftar";
                    continue;
                }

                // ✅ Parse tanggal lahir dengan berbagai kemungkinan nama kolom
                $tanggalLahirRaw = $this->getColumnValue($row, [
                    'tempattanggal_lahir',
                    'tempat_tanggal_lahir', 
                    'tanggal_lahir',
                    'Tempat,Tanggal Lahir',
                    'tempattangal_lahir' // typo yang sering terjadi
                ]);
                
                if (empty($tanggalLahirRaw)) {
                    $this->skipped++;
                    $this->errors[] = "Baris " . ($index + 2) . ": Kolom tanggal lahir tidak ditemukan. Kolom tersedia: " . implode(', ', array_keys($row->toArray()));
                    continue;
                }

                $tanggalLahir = $this->parseTanggalLahir($tanggalLahirRaw);
                
                if (!$tanggalLahir) {
                    $this->skipped++;
                    $this->errors[] = "Baris " . ($index + 2) . ": Tanggal lahir tidak valid ('{$tanggalLahirRaw}')";
                    continue;
                }

                // Password dari tanggal lahir (format: ddmmyyyy)
                $password = $tanggalLahir->format('dmY');

                // ✅ Create User
                $user = User::create([
                    'name' => $nama,
                    'email' => $nim . '@student.unsap.ac.id',
                    'password' => Hash::make($password),
                    'role' => 'user',
                    'is_active' => true,
                ]);

                // ✅ Get other fields dengan fallback
                $programStudi = $this->getColumnValue($row, ['program_studi', 'Program Studi', 'prodi']) ?? 'S1 Akuntansi';
                $tanggalMasuk = $this->parseTanggal($this->getColumnValue($row, ['tanggal_masuk', 'Tanggal Masuk'])) ?? now();
                $jenisKelamin = $this->getColumnValue($row, ['jenis_kelamin', 'Jenis Kelamin']) ?? 'L';

                // ✅ Create Student
                Student::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'nik' => $this->getColumnValue($row, ['nik', 'NIK']),
                    'nama' => $nama,
                    'program_studi' => $programStudi,
                    'tanggal_masuk' => $tanggalMasuk,
                    'status' => $this->getColumnValue($row, ['status', 'Status']) ?? 'AKTIF',
                    'jenis' => $this->getColumnValue($row, ['jenis', 'Jenis']) ?? 'Peserta didik baru',
                    'biaya_masuk' => $this->getColumnValue($row, ['biaya_masuk', 'Biaya Masuk']),
                    'jenis_kelamin' => $jenisKelamin,
                    'tempat_tanggal_lahir' => $tanggalLahir,
                    'agama' => $this->getColumnValue($row, ['agama', 'Agama']),
                    'alamat' => $this->getColumnValue($row, ['alamat', 'Alamat']),
                    'status_sync' => $this->getColumnValue($row, ['status_sync', 'Status Sync']) ?? 'Belum Sync',
                ]);

                $this->imported++;
                
                Log::info('Student imported', [
                    'nim' => $nim,
                    'nama' => $nama,
                    'password' => $password,
                    'email' => $nim . '@student.unsap.ac.id'
                ]);

            } catch (\Exception $e) {
                $this->skipped++;
                $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                Log::error('Error importing student', [
                    'row' => $index + 2,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'data' => $row->toArray()
                ]);
            }
        }
    }

    /**
     * ✅ Helper untuk get column value dengan multiple possible names
     */
    private function getColumnValue($row, array $possibleNames)
    {
        foreach ($possibleNames as $name) {
            if (isset($row[$name]) && !empty($row[$name])) {
                return $row[$name];
            }
        }
        return null;
    }

    /**
     * ✅ Parse tanggal lahir khusus (handle "Tempat, Tanggal" format)
     */
    private function parseTanggalLahir($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            // Jika format "SUMEDANG, 29 March 2007" -> ambil tanggalnya aja
            if (str_contains($dateString, ',')) {
                $parts = explode(',', $dateString);
                if (count($parts) >= 2) {
                    $dateString = trim($parts[1]); // "29 March 2007"
                }
            }

            return $this->parseTanggal($dateString);

        } catch (\Exception $e) {
            Log::warning('Failed to parse tanggal lahir', [
                'input' => $dateString,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Parse tanggal dari berbagai format
     */
    private function parseTanggal($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Jika sudah Carbon instance
            if ($date instanceof Carbon) {
                return $date;
            }

            // Jika format Excel date (numeric)
            if (is_numeric($date)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
            }

            // Parse berbagai format string
            $formats = [
                'd M Y',    // 29 March 2007
                'd F Y',    // 29 March 2007
                'd-M-y',    // 01-Sep-25
                'd/m/Y',    // 01/09/2025
                'Y-m-d',    // 2025-09-01
                'd-m-Y',    // 01-09-2025
                'd/m/y',    // 01/09/25
                'd-m-y',    // 01-09-25
                'j F Y',    // 29 March 2007 (without leading zero)
            ];

            foreach ($formats as $format) {
                try {
                    return Carbon::createFromFormat($format, trim($date));
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Last attempt: parse any format
            return Carbon::parse($date);

        } catch (\Exception $e) {
            Log::warning('Failed to parse date', [
                'date' => $date,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get import summary
     */
    public function getSummary(): array
    {
        return [
            'imported' => $this->imported,
            'skipped' => $this->skipped,
            'errors' => $this->errors,
            'total' => $this->imported + $this->skipped
        ];
    }
}