<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Move expired accreditations to historical type
        // Jalankan setiap hari jam 00:00
        $schedule->command('accreditations:move-expired')
            ->daily()
            ->at('00:00')
            ->timezone('Asia/Jakarta');
        
        // Atau jika ingin jalankan setiap minggu di hari Senin jam 01:00
        // $schedule->command('accreditations:move-expired')
        //     ->weekly()
        //     ->mondays()
        //     ->at('01:00')
        //     ->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}