@props(['status' => 'Available'])

@php
    $normalized = strtolower(trim($status ?? 'available'));

    [$classes, $label] = match ($normalized) {
        'available' => [
            'bg-[#e8f5e9] text-[#2E7D32] border-[#2E7D32]/20',
            'Available',
        ],
        'partially reserved' => [
            'bg-[#fef3c7] text-[#b45309] border-[#b45309]/20',
            'Partially Reserved',
        ],
        'fully reserved' => [
            'bg-[#e1ecf2] text-[#2c5266] border-[#2c5266]/20',
            'Fully Reserved',
        ],
        'partially redistributed' => [
            'bg-[#e1ecf2] text-[#2c5266] border-[#2c5266]/20',
            'Partially Redistributed',
        ],
        'fully redistributed' => [
            'bg-[#e8f5e9] text-[#2E7D32] border-[#2E7D32]/20',
            'Fully Redistributed',
        ],
        'expired' => [
            'bg-[#fee2e2] text-[#b91c1c] border-[#b91c1c]/20',
            'Expired',
        ],
        'withdrawn' => [
            'bg-[#e8efe9] text-[#4a5d50] border-[#d5dfd8]',
            'Withdrawn',
        ],
        default => [
            'bg-[#e8efe9] text-[#4a5d50] border-[#d5dfd8]',
            ucfirst($status),
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border $classes"]) }}>
    {{ $label }}
</span>
