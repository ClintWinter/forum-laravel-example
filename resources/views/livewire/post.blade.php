<div class="container mx-auto py-12 px-4">
    {{-- post + comments + new comment --}}
    <div class="w-full xl:w-2/3 mx-auto">
        {{-- post --}}
        <div class="bg-white px-8 py-12 mb-8 rounded-sm shadow">
            <h1 class="text-xl font-bold leading-tight mb-12">{{ $post->title }}</h1>

            <div class="mb-12 flex">
                {{-- score --}}
                @if(auth()->check())
                    <div class="w-10 flex flex-col items-center mr-4">
                        <x-btn.link wire:click="upvote">
                            <i class="fas fa-chevron-circle-up {{ $this->post->isUpvotedBy(auth()->user()) ? 'text-green-500' : 'text-gray-300' }}"></i>
                        </x-btn.link>

                        <span class="text-xl py-2">{{ $this->post->score() }}</span>

                        <x-btn.link wire:click="downvote">
                            <i class="fas fa-chevron-circle-down {{ $this->post->isDownvotedBy(auth()->user()) ? 'text-orange-500' : 'text-gray-300' }}"></i>
                        </x-btn.link>
                    </div>
                @endif

                <p class="whitespace-pre-wrap">{{ $post->body }}</p>
            </div>

            <div class="flex justify-between">
                <div class="text-gray-700 text-xs flex items-center space-x-2">
                    <span class="text-xl fa-stack leading-none">
                        <i class="fas fa-square fa-stack-2x text-gray-100"></i>
                        <i class="far fa-square fa-stack-2x text-gray-200"></i>
                        <i class="fas fa-user fa-stack-1x text-gray-400"></i>
                    </span>

                    <div class="flex flex-col">
                        <a class="text-gray-700 hover:text-gray-900 text-sm" href="{{ $post->user->path() }}">{{ $post->user->name }}</a>
                        <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @can('update', $post)
                    <div>
                        <x-link href="/posts/{{ $post->id }}/edit" class="mr-2 text-xs text-gray-700">Edit</x-link>

                        <x-modal class="inline-block">
                            <x-slot name="trigger">
                                <x-btn.link class="text-xs text-gray-700" role="button" @click="open = !open">Delete</x-btn.link>
                            </x-slot>

                            <div class="p-2">
                                <h2 class="mb-8">Are you sure you want to delete this post?</h2>

                                <div class="flex justify-center items-center">
                                    <x-btn.link class="mr-4" @click="open = false">No</x-btn.link>
                                    <x-form-button action="/posts/{{ $post->id}}" method="DELETE">
                                        <x-btn.primary type="submit">Yes</x-btn.primary>
                                    </x-form-button>
                                </div>
                            </div>
                        </x-modal>
                    </div>
                @endcan
            </div>
        </div>

        <x-comment.list :comments="$comments" />

        {{-- new comment --}}
        @auth
            <div class="mt-16 bg-white rounded-sm shadow">
                @if($errors->has('body'))
                    <div class="border border-red-600 rounded-sm bg-red-300 text-red-900 p-4 pb-2 mb-4">
                        @foreach ($errors->get('body') as $error)
                            <p class="mb-2">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <textarea name="body" wire:model.defer="body" placeholder="Comment..." class="resize-y border border-gray-300 w-full h-32 p-2 max-h-64 mb-8"></textarea>

                    <div class="flex justify-end">
                        <x-btn.primary wire:click="addComment">Post comment</x-btn.primary>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-sm shadow p-4 py-8 mt-16">
                <p class="text-center mb-2 text-lg">Want to be part of the conversation?</p>
                <p class="text-center"><x-link class="text-blue-500" href="/login">Log in</x-link> or <x-link class="text-blue-500" href="/register">Sign up!</x-link></p>
            </div>
        @endauth
    </div>
</div>
