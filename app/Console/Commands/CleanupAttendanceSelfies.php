<?php

namespace App\Console\Commands;

use App\Services\AttendanceSelfieCleanupService;
use Illuminate\Console\Command;

class CleanupAttendanceSelfies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:cleanup-selfies {--days=14 : Number of days to keep selfies} {--stats : Show storage statistics instead of cleaning}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete attendance selfie images older than specified days while keeping attendance records';

    /**
     * Execute the console command.
     */
    public function handle(AttendanceSelfieCleanupService $cleanupService)
    {
        if ($this->option('stats')) {
            return $this->showStats($cleanupService);
        }

        $days = (int) $this->option('days');
        
        $this->info("Starting cleanup of attendance selfies older than {$days} days...");
        $this->newLine();

        $result = $cleanupService->cleanupOldSelfies($days);

        $this->info("Cleanup completed:");
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Processed', $result['total_processed']],
                ['Successfully Deleted', $result['deleted_count']],
                ['Failed', $result['failed_count']],
                ['Skipped (already deleted)', $result['skipped_count']],
                ['Cutoff Date', $result['cutoff_date']],
            ]
        );

        if (!empty($result['errors'])) {
            $this->newLine();
            $this->error('Errors encountered:');
            foreach ($result['errors'] as $error) {
                $this->error("  - {$error}");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Show storage statistics
     */
    protected function showStats(AttendanceSelfieCleanupService $cleanupService): int
    {
        $this->info('Attendance Selfie Storage Statistics');
        $this->newLine();

        $stats = $cleanupService->getStorageStats();

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Selfies', $stats['total_selfies']],
                ['Recent Selfies (< 14 days)', $stats['recent_selfies']],
                ['Old Selfies (> 14 days)', $stats['old_selfies']],
                ['Total Storage Used', $stats['total_size_mb'] . ' MB'],
                ['Potential Cleanup Savings', $stats['cleanup_potential_mb'] . ' MB'],
            ]
        );

        return Command::SUCCESS;
    }
}
