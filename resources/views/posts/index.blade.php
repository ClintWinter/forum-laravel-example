@extends('layout.master')
@section('main')

<div class="container mx-auto p-4">

    <div class="h-8"></div>

    <div class="flex justify-between items-center">
        <h1 class="text-2xl uppercase tracking-widest text-gray-600 font-thin">Posts</h1>

        <button class="bg-gray-800 hover:bg-gray-900 border border-gray-900 text-white uppercase font-bold px-4 py-1 rounded-sm">New post</button>
    </div>

    <div class="h-8"></div>

    <div class="flex justify-around flex-wrap items-stretch">
        @foreach ($posts as $post)
            <div class="p-4 mb-4 border border-gray-300 rounded">
                <h2 class="font-bold leading-none">
                    <a class="underline" href="/posts/{{$post->id}}">{{ $post->title }}</a>
                </h2>

                <div class="h-4"></div>
                
                <p>{{ strlen($post->body) > 100 ? substr($post->body, 0, 100) . '...' : $post->body }}</p>

                <div class="h-4"></div>

                <div class="flex justify-between items-end">
                    <p>
                        <small class="text-xs text-gray-600">
                            <i class="fas fa-user"></i> 
                            <a 
                                class="underline" 
                                href="/users/{{$post->user->id}}"
                            >{{ $post->user->name }}</a>
                            • {{ $post->created_at->format('n/j/Y g:i A') }} 
                        </small>
                    </p>

                    <p class="text-lg text-gray-600">
                        {{$post->comments_count}} 
                        <span class="pl-2"></span>
                        <i class="fas fa-comments"></i>
                    </p>
                </div>
            </div>
        @endforeach
    </div>

</div>
    
@endsection