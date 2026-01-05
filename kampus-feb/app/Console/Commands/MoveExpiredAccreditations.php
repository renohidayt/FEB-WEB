<?php

namespace App\Console\Commands;

use App\Models\Accreditation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MoveExpiredAccreditations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accreditations:move-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move expired accreditations to old/historical type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking for expired accreditations...');
        $this->newLine();
        
        $moved = 0;
        $errors = 0;

        // Pindahkan PT yang expired
        $this->line('📋 Checking Perguruan Tinggi accreditations...');
        $expiredPT = Accreditation::where('type', Accreditation::TYPE_PT)
            ->where('valid_until', '<', now())
            ->get();
        
        if ($expiredPT->count() > 0) {
            foreach ($expiredPT as $acc) {
                try {
                    $acc->update([
                        'type' => Accreditation::TYPE_PT_OLD,
                        'is_active' => false
                    ]);
                    $moved++;
                    $this->line("  ✓ Moved PT: {$acc->study_program} (expired: {$acc->valid_until->format('Y-m-d')})");
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("  ✗ Failed to move PT: {$acc->study_program} - {$e->getMessage()}");
                    Log::error('Failed to move expired PT accreditation', [
                        'id' => $acc->id,
                        'program' => $acc->study_program,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } else {
            $this->line('  No expired PT accreditations found.');
        }
        
        $this->newLine();

        // Pindahkan Prodi yang expired
        $this->line('📋 Checking Program Studi accreditations...');
        $expiredProdi = Accreditation::where('type', Accreditation::TYPE_PRODI)
            ->where('valid_until', '<', now())
            ->get();
        
        if ($expiredProdi->count() > 0) {
            foreach ($expiredProdi as $acc) {
                try {
                    $acc->update([
                        'type' => Accreditation::TYPE_PRODI_OLD,
                        'is_active' => false
                    ]);
                    $moved++;
                    $this->line("  ✓ Moved Prodi: {$acc->study_program} (expired: {$acc->valid_until->format('Y-m-d')})");
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("  ✗ Failed to move Prodi: {$acc->study_program} - {$e->getMessage()}");
                    Log::error('Failed to move expired Prodi accreditation', [
                        'id' => $acc->id,
                        'program' => $acc->study_program,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } else {
            $this->line('  No expired Program Studi accreditations found.');
        }

        $this->newLine();

        // Summary
        if ($moved > 0) {
            Log::info("Successfully moved {$moved} expired accreditations to historical type");
            $this->info("✅ Successfully moved {$moved} expired accreditation(s) to historical type");
        } else {
            $this->info("✅ No expired accreditations to move");
        }

        if ($errors > 0) {
            $this->warn("⚠️  {$errors} error(s) occurred during the process");
        }

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}