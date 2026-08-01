<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @php
                $userId = auth()->id();
                $currentMonth = now()->format('Y-m');
                $present = \App\Models\Attendance::where('user_id', $userId)
                    ->whereYear('date', now()->year)
                    ->whereMonth('date', now()->month)
                    ->where('status', 'present')
                    ->count();
                $absent = \App\Models\Attendance::where('user_id', $userId)
                    ->whereYear('date', now()->year)
                    ->whereMonth('date', now()->month)
                    ->where('status', 'absent')
                    ->count();
                $leave = \App\Models\Attendance::where('user_id', $userId)
                    ->whereYear('date', now()->year)
                    ->whereMonth('date', now()->month)
                    ->where('status', 'leave')
                    ->count();
                $late = \App\Models\Attendance::where('user_id', $userId)
                    ->whereYear('date', now()->year)
                    ->whereMonth('date', now()->month)
                    ->where('status', 'late')
                    ->count();
            @endphp

            <div class="bg-success-50 dark:bg-success-900/20 rounded-xl p-6">
                <div class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $present }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Present</div>
            </div>

            <div class="bg-danger-50 dark:bg-danger-900/20 rounded-xl p-6">
                <div class="text-2xl font-bold text-danger-600 dark:text-danger-400">{{ $absent }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Absent</div>
            </div>

            <div class="bg-warning-50 dark:bg-warning-900/20 rounded-xl p-6">
                <div class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $leave }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Leave</div>
            </div>

            <div class="bg-primary-50 dark:bg-primary-900/20 rounded-xl p-6">
                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $late }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Late</div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-4">Attendance History</h3>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
