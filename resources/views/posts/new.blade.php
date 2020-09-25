<x-master>
<x-container>

<h1 class="text-3xl font-thin uppercase text-gray-600">New post</h1>

<hr class="my-8">

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

<form action="/posts" method="POST">
    @csrf

    <div>
        <label>Title</label>

        <div class="h-2"></div>
        
        <input 
            class="w-full p-2 border border-gray-300 rounded-sm outline-none focus:border-blue-300"
            type="text" 
            name="title" 
            autofocus 
            required 
            placeholder="Title..."
        >
    </div>

    <div class="h-8"></div>

    <div>
        <label>Body</label>

        <div class="h-2"></div>
        
        <textarea 
            class="resize-none w-full p-2 border border-gray-300 rounded-sm outline-none focus:border-blue-300" 
            name="body" 
            required 
            placeholder="Body text..."
        ></textarea>
    </div>

    <div class="h-8"></div>

    <div>
        <x-btn-primary type="submit">Create post</x-btn-primary>
    </div>
</form>

</x-container>
</x-master>