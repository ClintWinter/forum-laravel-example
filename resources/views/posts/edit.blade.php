<x-master>
<x-container>

<div class="h-8"></div>
    
<x-page-header>Edit post</x-page-header>

<hr class="my-8">

<x-form-errors />

<form action="/posts/{{$post->id}}" method="POST">
    @csrf
    @method('PATCH')

    <h2 class="text-3xl font-bold">{{$post->title}}</h2>

    <div class="h-8"></div>

    <div>
        <label class="font-bold text-sm">Body</label>

        <div class="h-2"></div>
        
        <textarea 
            class="resize-none w-full p-2 border border-gray-300 rounded-sm outline-none focus:border-blue-300" 
            name="body" 
            required 
            placeholder="Body text..."
        >{{$post->body}}</textarea>
    </div>

    <div class="h-8"></div>

    <div>
        <x-btn.primary type="submit">Update post</x-btn.primary>
    </div>

</form>
    
</x-container>
</x-master>