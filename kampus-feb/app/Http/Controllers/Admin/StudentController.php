<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display listing of students
     */
    public function index(Request $request)
    {
        $query = Student::with('user')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by prodi
        if ($request->filled('prodi')) {
            $query->where('program_studi', $request->prodi);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(50);

        // Get all program studi for filter
        $prodis = Student::select('program_studi')
            ->distinct()
            ->pluck('program_studi');

        return view('admin.students.index', compact('students', 'prodis'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store new student
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:students,nim',
            'nik' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'program_studi' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:AKTIF,CUTI,LULUS,KELUAR',
            'jenis' => 'nullable|string',
            'biaya_masuk' => 'nullable|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            // Generate password from birth date (format: DDMMYYYY)
            $birthDate = \Carbon\Carbon::parse($validated['tempat_tanggal_lahir']);
            $password = $birthDate->format('dmY'); // Example: 29032007

            // Create User
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['nim'] . '@student.unsap.ac.id',
                'password' => Hash::make($password),
                'role' => 'user',
                'is_active' => true,
            ]);

            // Create Student
            Student::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'program_studi' => $validated['program_studi'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'status' => $validated['status'],
                'jenis' => $validated['jenis'] ?? 'Peserta didik baru',
                'biaya_masuk' => $validated['biaya_masuk'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_tanggal_lahir' => $validated['tempat_tanggal_lahir'],
                'agama' => $validated['agama'],
                'alamat' => $validated['alamat'],
                'status_sync' => 'Belum Sync',
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', "Mahasiswa {$validated['nama']} berhasil ditambahkan. Password: {$password}");

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->with('error', 'Gagal menambahkan mahasiswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('admin.students.import');
    }

    /**
     * Process import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        try {
            $import = new StudentsImport();
            
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            $message = "Import selesai! Berhasil: {$summary['imported']}, Dilewati: {$summary['skipped']}";

            if ($summary['skipped'] > 0) {
                session()->flash('errors', $summary['errors']);
            }

            return redirect()->route('admin.students.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal import: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_mahasiswa.xlsx');
        
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'Template tidak ditemukan');
    }

    /**
     * Show student detail
     */
    public function show(Student $student)
    {
        $student->load('user');
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show edit form
     */
    public function edit(Student $student)
    {
        $student->load('user');
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update student
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'program_studi' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:AKTIF,CUTI,LULUS,KELUAR',
            'jenis' => 'nullable|string',
            'biaya_masuk' => 'nullable|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            // Update student
            $student->update($validated);

            // Update user name
            $student->user->update([
                'name' => $validated['nama'],
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Data mahasiswa berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete student
     */
    public function destroy(Student $student)
    {
        try {
            DB::beginTransaction();

            // Get user before deleting student
            $user = $student->user;
            $nama = $student->nama;

            // Delete student
            $student->delete();

            // Delete user
            if ($user) {
                $user->delete();
            }

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', "Mahasiswa {$nama} berhasil dihapus");

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'Gagal menghapus mahasiswa: ' . $e->getMessage());
        }
    }
}