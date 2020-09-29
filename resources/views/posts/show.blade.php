<x-master>

    <div class="container mx-auto py-12 px-4">
        {{-- post + comments + new comment --}}
        <div class="w-full lg:w-1/2 mx-auto">
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
                        </div>
                    @endcan
                </div>
            </div>

            <div class="h-4"></div>

            @if (isset($comments[0]))
                <div>
                    @foreach ($comments[0] as $comment)
                        <x-comment.list-item 
                            :post="$post"
                            :comments="$comments" 
                            :comment="$comment"
                        ></x-comment.list-item>
                    @endforeach
                </div>
            @endif
        
            <div class="h-16"></div>

            {{-- new comment --}}
            @auth
                <div class="bg-gray-100 border border-gray-300 rounded-sm p-4">

                    @if($errors->any())
                        <div class="border border-red-600 rounded-sm bg-red-300 text-red-900 p-4 pb-2 mb-4">
                            @foreach ($errors->all() as $error)
                                <p class="mb-2">{{$error}}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form action="/posts/{{$post->id}}/comments" method="POST">
                        @csrf

                        <textarea 
                            name="body" 
                            placeholder="Comment..."
                            class="resize-y border border-gray-300 w-full h-32 p-2"
                        ></textarea>

                        <div class="h-8"></div>
                        
                        <div class="flex justify-end">
                            <x-btn.primary type="submit">Post comment</x-btn.primary>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-gray-100 border border-gray-300 rounded-sm p-4 py-8">
                    <p class="text-center mb-2 text-lg">Want to be part of the conversation?</p>
                    <p class="text-center">
                        <x-link class="text-blue-500" href="/login">Log in</x-link>
                        or
                        <x-link class="text-blue-500" href="/register">Sign up!</x-link>
                    </p>
                </div>
            @endauth
        </div>
    </div>

</x-master>