<button 
    {{ $attributes->merge(['class' => 'hover:underline']) }}
>{{ $slot }}</button>