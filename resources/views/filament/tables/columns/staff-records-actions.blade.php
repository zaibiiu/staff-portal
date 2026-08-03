<div class="items-center gap-2 justify-start">
    <a 
        href="{{ \App\Filament\Resources\StaffProfileResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #3b82f6; padding: .4rem;"
        x-tooltip.raw="Staff Profile"
    >
        <x-filament::icon icon="heroicon-o-identification" class="w-5 h-5" />
    </a>
    
    <a 
        href="{{ \App\Filament\Resources\SalaryResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #10b981; padding: .4rem;"
        x-tooltip.raw="Salary History"
    >
        <x-filament::icon icon="heroicon-o-banknotes" class="w-5 h-5" />
    </a>
    
    <a 
        href="{{ \App\Filament\Resources\DocumentResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #f59e0b; padding: .4rem;"
        x-tooltip.raw="Documents"
    >
        <x-filament::icon icon="heroicon-o-document-text" class="w-5 h-5" />
    </a>
    
    <a 
        href="{{ \App\Filament\Resources\StaffTaskResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #06b6d4; padding: .4rem"
        x-tooltip.raw="Tasks"
    >
        <x-filament::icon icon="heroicon-o-clipboard-document-check" class="w-5 h-5" />
    </a>
    
    <a 
        href="{{ \App\Filament\Resources\CommissionResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #a855f7; padding: .4rem"
        x-tooltip.raw="Commissions"
    >
        <x-filament::icon icon="heroicon-o-currency-dollar" class="w-5 h-5" />
    </a>
    
    <a 
        href="{{ \App\Filament\Resources\AttendanceResource::getUrl('index', ['user' => $getRecord()->id]) }}"
        class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white transition-all hover:scale-110"
        style="background-color: #6b7280; padding: .4rem"
        x-tooltip.raw="Attendance"
    >
        <x-filament::icon icon="heroicon-o-calendar-days" class="w-5 h-5" />
    </a>
</div>
