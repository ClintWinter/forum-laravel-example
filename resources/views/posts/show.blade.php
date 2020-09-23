@extends('layout.master')
@section('main')


    <div class="container mx-auto py-12 px-8">
        <div>
            <a class="text-blue-500 underline" href="/posts">View All</a>
        </div>

        <div class="h-8"></div>
        
        {{-- post --}}
        <div>
            <h1 class="text-3xl">{{$post->title}}</h1>

            <div class="h-4"></div>

            <p>{{$post->body}}</p>

            <div class="h-4"></div>

            <p>
                <small class="text-gray-700">
                    <i class="fas fa-user"></i> {{$post->user->name}}
                    • {{$post->created_at->format('n/j/Y g:i A')}}
                </small>
            </p>
        </div>

        @foreach ($post->comments()->orderBy('created_at')->get() as $comment)
            <div class="h-8"></div>

            <div>
                <hr>
                
                <div class="h-8"></div>

                <p class="text-gray-800">
                    <i class="fas fa-user"></i>
                    <span class="text-sm">{{$comment->user->name}}</span>
                </p>

                <div class="h-4"></div>
                
                <p>{{$comment->body}}</p>

                <div class="h-4"></div>

                <p><small class="text-gray-700">{{$comment->created_at->format('n/j/Y g:i A')}}</small></p>
            </div>
        @endforeach
        
        <div class="h-16"></div>

        {{-- new comment --}}
        <div class="border border-gray-300 rounded-sm p-4">
            <textarea 
                name="" 
                id="" 
                placeholder="Comment..."
                class="resize-y border border-gray-300 w-full h-32 p-2"
            ></textarea>

            <div class="h-8"></div>
            
            <div class="flex justify-end">
                <button 
                    class="bg-gray-800 hover:bg-gray-900 border border-gray-900 uppercase text-white uppercase font-bold px-4 py-1"
                >Post comment</button>
            </div>
        </div>
    </div>

@endsection