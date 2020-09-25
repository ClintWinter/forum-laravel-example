<x-master>

    <div class="container mx-auto py-12 px-4">
        <div>
            <x-link class="text-blue-500" href="/posts">View All</x-link>
        </div>

        <div class="h-8"></div>
        
        {{-- post --}}
        <div>
            <div>
                <h1 class="text-3xl">{{$post->title}}</h1>
            </div>

            <div class="h-4"></div>

            <div>
                <p class="whitespace-pre-wrap">{{$post->body}}</p>
            </div>

            <div class="h-4"></div>

            <div class="flex justify-between">
                <p>
                    <small class="text-gray-700">
                        <i class="fas fa-user"></i> {{$post->user->name}}
                        • {{$post->created_at->format('n/j/Y g:i A')}}
                    </small>
                </p>

                @can('update', $post)
                    <div>
                        <x-link href="/posts/{{$post->id}}/edit" class="mr-2">Edit</x-link>
                        <x-modal class="inline-block">
                            <x-slot name="trigger">
                                <x-btn.link role="button" @click="open = !open">Delete</x-btn.link>
                            </x-slot>

                            <div class="p-2">
                                <h2>Are you sure you want to delete this post?</h2>

                                <div class="h-8"></div>
                                
                                <div class="flex justify-center items-center">
                                    <x-btn.link class="mr-4" @click="open = false">No</x-btn.link>

                                    <x-form-button action="/posts/{{$post->id}}" method="DELETE">
                                        <x-btn.primary type="submit">Yes</x-btn.primary>
                                    </x-form-button>
                                </div>
                            </div>
                        </x-modal>
                        {{-- <x-form-button 
                            action="/posts/{{$post->id}}" 
                            method="DELETE"
                            class="underline"
                        >Delete</x-form-button> --}}
                    </div>
                @endcan
            </div>
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
        <div class="bg-gray-100 border border-gray-300 rounded-sm p-4">
            <textarea 
                name="" 
                id="" 
                placeholder="Comment..."
                class="resize-y border border-gray-300 w-full h-32 p-2"
            ></textarea>

            <div class="h-8"></div>
            
            <div class="flex justify-end">
                <x-btn.primary>Post comment</x-btn.primary>
            </div>
        </div>
    </div>

</x-master>