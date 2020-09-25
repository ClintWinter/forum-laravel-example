@if($errors->any())
<div>
    <ul class="border border-red-500 bg-red-200 rounded p-4 pl-8 list-disc">
        @foreach($errors->all() as $error)
            <li class="text-red-800 mb-1">{{$error}}</li>
        @endforeach
    </ul>
</div>

<div class="h-8"></div>
@endif