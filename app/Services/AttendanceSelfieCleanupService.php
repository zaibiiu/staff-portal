<?php

namespace App\Services;

use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;

class AttendanceSelfieCleanupService
{
    /**
     * Delete attendance selfie images older than specified days
     * while keeping attendance records intact.
     *
     * @param int $days Number of days to keep selfies (default: 14)
     * @return array Array with cleanup statistics
     */
    public function cleanupOldSelfies(int $days = 14): array
    {
        $cutoffDate = now()->subDays($days);
        
        $attendances = Attendance::where('selfie_taken_at', '<', $cutoffDate)
            ->whereNotNull('selfie')
            ->where('selfie', '!=', '')
            ->get();

        $deletedCount = 0;
        $failedCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($attendances as $attendance) {
            try {
                if (Storage::disk('public')->exists($attendance->selfie)) {
                    Storage::disk('public')->delete($attendance->selfie);
                    $deletedCount++;
                } else {
                    $skippedCount++;
                }
                
                // Clear the selfie reference in the database
                $attendance->update([
                    'selfie' => null,
                    'selfie_taken_at' => null,
                ]);
                
            } catch (\Exception $e) {
                $failedCount++;
                $errors[] = "Attendance ID {$attendance->id}: {$e->getMessage()}";
            }
        }

        return [
            'success' => true,
            'deleted_count' => $deletedCount,
            'failed_count' => $failedCount,
            'skipped_count' => $skippedCount,
            'total_processed' => $attendances->count(),
            'cutoff_date' => $cutoffDate->toDateTimeString(),
            'errors' => $errors,
        ];
    }

    /**
     * Get statistics about current selfie storage usage
     *
     * @return array Storage statistics
     */
    public function getStorageStats(): array
    {
        $totalSelfies = Attendance::whereNotNull('selfie')
            ->where('selfie', '!=', '')
            ->count();

        $oldSelfies = Attendance::where('selfie_taken_at', '<', now()->subDays(14))
            ->whereNotNull('selfie')
            ->where('selfie', '!=', '')
            ->count();

        $recentSelfies = $totalSelfies - $oldSelfies;

        // Calculate approximate storage size
        $totalSize = 0;
        $attendances = Attendance::whereNotNull('selfie')
            ->where('selfie', '!=', '')
            ->get();

        foreach ($attendances as $attendance) {
            try {
                if (Storage::disk('public')->exists($attendance->selfie)) {
                    $totalSize += Storage::disk('public')->size($attendance->selfie);
                }
            } catch (\Exception $e) {
                // Skip files that can't be accessed
            }
        }

        return [
            'total_selfies' => $totalSelfies,
            'old_selfies' => $oldSelfies,
            'recent_selfies' => $recentSelfies,
            'total_size_bytes' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2),
            'cleanup_potential_mb' => $totalSelfies > 0 
                ? round(($totalSize / $totalSelfies) * $oldSelfies / 1024 / 1024, 2) 
                : 0,
        ];
    }
}
