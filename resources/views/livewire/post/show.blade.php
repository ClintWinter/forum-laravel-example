<div class="container mx-auto py-12 px-4">
    {{-- post + comments + new comment --}}
    <div class="w-full lg:w-1/2 mx-auto">
        {{-- post --}}
        <div class="border border-gray-300 rounded px-4 py-2">
            <div class="py-4">
                <h1 class="text-xl font-bold leading-tight">{{ $post->title }}</h1>
            </div>

            <hr class="mb-8">

            <p class="whitespace-pre-wrap mb-12">{{ $post->body }}</p>

            <div class="flex justify-between">
                <p class="text-gray-700 text-xs flex items-center space-x-2">
                    <i class="fas fa-user text-lg"></i>
                    <span class="font-bold text-gray-900 text-sm mr-1">{{ $post->user->name }}</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </p>

                @can('update', $post)
                    <div>
                        <x-link
                            href="/posts/{{ $post->id }}/edit"
                            class="mr-2 text-xs text-gray-700"
                        >Edit</x-link>

                        <x-modal class="inline-block">
                            <x-slot name="trigger">
                                <x-btn.link
                                    class="text-xs text-gray-700"
                                    role="button"
                                    @click="open = !open"
                                >Delete</x-btn.link>
                            </x-slot>

                            <div class="p-2">
                                <h2>Are you sure you want to delete this post?</h2>

                                <div class="h-8"></div>

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

        <div class="h-4"></div>

        <x-comment.list :comments="$comments"/>

        <div class="h-16"></div>

        {{-- new comment --}}
        @auth
            <div class="bg-gray-100 border border-gray-300 rounded-sm p-4">

                @if($errors->any())
                    <div class="border border-red-600 rounded-sm bg-red-300 text-red-900 p-4 pb-2 mb-4">
                        @foreach ($errors->all() as $error)
                            <p class="mb-2">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form wire:submit.prevent="addComment">
                    @csrf

                    <textarea
                        name="body"
                        wire:model.defer="body"
                        placeholder="Comment..."
                        class="resize-y border border-gray-300 w-full h-32 p-2 max-h-64"
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