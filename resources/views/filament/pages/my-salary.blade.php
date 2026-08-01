<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Current Salary</h3>
            @php
                $currentSalary = auth()->user()->currentSalary;
            @endphp
            @if($currentSalary)
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                    PKR {{ number_format($currentSalary->amount, 2) }}
                </div>
                <p class="text-sm text-gray-500 mt-2">Effective from {{ $currentSalary->effective_date->format('M d, Y') }}</p>
            @else
                <p class="text-gray-500">No salary information available</p>
            @endif
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-4">Salary History</h3>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
