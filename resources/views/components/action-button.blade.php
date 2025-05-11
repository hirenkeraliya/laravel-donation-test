@props([
    'href' => '#',
    'type' => 'primary',
    'onClick' => null
])

<a
    href="{{ $href }}"
    @if($onClick) onclick="{{ $onClick }}" @endif
    {{ $attributes->merge([
        'class' => 'inline-block w-full px-6 py-3 rounded-md transition-colors text-center ' .
        ($type === 'primary'
            ? 'bg-[#B08D57] text-white hover:bg-[#96784A]'
            : 'text-[#B08D57] hover:text-[#96784A] font-medium')
    ]) }}
>
    {{ $slot }}
</a>
