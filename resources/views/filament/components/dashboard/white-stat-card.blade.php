@props(['title', 'value', 'iconColor', 'icon'])

<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center gap-4">
        <div class="p-3 bg-{{ $iconColor }}-100 rounded-lg">
            <svg class="w-7 h-7 text-{{ $iconColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
        <div>
            <p class="text-gray-600 text-sm">{{ $title }}</p>
            <p class="text-gray-900 text-2xl font-bold">{{ $value }}</p>
        </div>
    </div>
</div>
