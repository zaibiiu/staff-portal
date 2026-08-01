<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Total Commission Earned</h3>
            @php
                $totalCommission = auth()->user()->commissions()->sum('amount');
            @endphp
            <div class="text-3xl font-bold text-success-600 dark:text-success-400">
                PKR {{ number_format($totalCommission, 2) }}
            </div>
            <p class="text-sm text-gray-500 mt-2">All time earnings</p>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-4">Commission History</h3>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
