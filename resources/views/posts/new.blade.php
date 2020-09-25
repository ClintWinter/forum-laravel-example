<x-master>
<x-container>

<div class="h-8"></div>

<x-page-header>New post</x-page-header>

<hr class="my-8">

<x-form-errors />

<form action="/posts" method="POST">
    @csrf

    <div>
        <label class="font-bold text-sm">Title</label>

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
        <label class="font-bold text-sm">Body</label>

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
        <x-btn.primary type="submit">Create post</x-btn.primary>
    </div>
</form>

</x-container>
</x-master>