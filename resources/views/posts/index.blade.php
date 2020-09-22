@extends('layout.master')
@section('main')

<div class="container mx-auto">

    <div class="h-8"></div>

    <h1 class="uppercase tracking-widest text-gray-600 font-thin">Posts</h1>

    <div class="h-8"></div>

    <div class="flex justify-around flex-wrap items-stretch p-4">
        @foreach ($posts as $post)
            <div class="p-4 mb-4 border border-gray-300 rounded">
                <h2 class="font-bold leading-none">
                    <a class="text-blue-500 underline" href="/posts/{{$post->id}}">{{ $post->title }}</a>
                </h2>

                <div class="h-4"></div>
                
                <p>{{ strlen($post->body) > 100 ? substr($post->body, 0, 100) . '...' : $post->body }}</p>

                <div class="h-4"></div>

                <p>
                    <small class="text-xs text-gray-600">
                        {{ $post->created_at->format('n/j/Y g:i A') }} 
                        • Posted by <a 
                            class="text-blue-500 underline" 
                            href="/users/{{$post->user->id}}"
                        >{{ $post->user->name }}</a>
                    </small>
                </p>
            </div>
        @endforeach
    </div>

</div>
    
@endsection