@props(['status' => 'Pending'])

@php
    $normalized = strtolower(trim($status ?? 'pending'));

    [$classes, $label] = match ($normalized) {
        'verified', 'available' => [
            'bg-[#e8f5e9] text-[#2E7D32] border-[#2E7D32]/20',
            'Verified',
        ],
        'additional information required' => [
            'bg-[#fef3c7] text-[#b45309] border-[#b45309]/20',
            'Additional Information Required',
        ],
        'rejected', 'expired' => [
            'bg-[#fee2e2] text-[#b91c1c] border-[#b91c1c]/20',
            'Rejected',
        ],
        default => [
            'bg-[#e8efe9] text-[#4a5d50] border-[#d5dfd8]',
            'Pending Review',
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border $classes"]) }}>
    {{ $label }}
</span>
