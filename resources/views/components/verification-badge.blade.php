@props(['status' => 'Pending'])

@php
    $normalized = strtolower(trim($status ?? 'pending'));

    [$classes, $dotColor, $label] = match ($normalized) {
        'verified', 'available' => [
            'bg-emerald-100 text-emerald-800 border-emerald-200',
            'bg-emerald-600',
            'Verified',
        ],
        'additional information required' => [
            'bg-amber-100 text-amber-800 border-amber-200',
            'bg-amber-600',
            'Additional Information Required',
        ],
        'rejected', 'expired' => [
            'bg-rose-100 text-rose-800 border-rose-200',
            'bg-rose-600',
            'Rejected',
        ],
        default => [
            'bg-slate-100 text-slate-700 border-slate-200',
            'bg-slate-500',
            'Pending Review',
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border $classes"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    {{ $label }}
</span>
