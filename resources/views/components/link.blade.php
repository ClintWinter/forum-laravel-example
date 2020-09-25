@props([
    'href' => '',
    'external' => false,
])

<a 
    {{ $attributes->merge(['class' => 'hover:underline']) }}

    @if($href)
        href="{{ $href }}"
    @endif
    
    @if($external)
        target="blank" rel="noopener noreferer"
    @endif
>{{ $slot }}</a>