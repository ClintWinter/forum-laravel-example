@props([
    'action' => '',
    'method' => 'GET'
])

<form 
    class="inline-block" 
    action="{{$action}}" 
    method="{{$method === 'GET' ? 'GET' : 'POST'}}"
>
    @csrf

    @if($method !== 'GET' && $method !== 'POST')
        @method($method)
    @endif

    {{$slot}}
</form>