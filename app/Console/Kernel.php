<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Interfaces\FileRepositoryInterface;

class Kernel extends ConsoleKernel
{
    // private FileRepositoryInterface $fileRepository;

    // public function __construct(FileRepositoryInterface $fileRepository)
    // {
    //     $this->fileRepository = $fileRepository;
    // }
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     $this->fileRepository->checkRepetitive();
        // })->daily();
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
