@props(['color', 'title', 'value', 'icon'])

<div class="relative bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 rounded-lg p-8 overflow-hidden" style="min-height: 140px;">
    <div class="absolute top-6 right-6 opacity-20">
        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    </div>
    <div class="relative">
        <h3 class="text-white text-sm font-medium mb-2">{{ $title }}</h3>
        <p class="text-white text-5xl font-bold">{{ $value }}</p>
    </div>
</div>
