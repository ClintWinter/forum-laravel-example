<x-master>
    <x-container class="pt-8">
        <div class="flex justify-between items-center">
            <x-page-header>Posts</x-page-header>

            @auth
                <x-link-primary href="/posts/new">New post</x-link-primary>
            @endauth
        </div>

        <div class="h-8"></div>

        <div class="flex justify-around flex-wrap items-stretch border border-gray-300">
            <div class="h-4"></div>

            @foreach ($posts as $post)
                <div class="w-full mx-4 mb-4 pb-4 flex items-center justify-between border-b border-gray-100 last:border-b-0">
                    <div class="flex-grow">
                        <h2 class="font-bold leading-none" title="{{ \Str::limit($post->body, 100) }}">
                            <x-link href="/posts/{{ $post->id }}">{{ $post->title }}</x-link>
                        </h2>

                        <div class="flex justify-between items-end">
                            <p>
                                <small class="text-xs text-gray-600">
                                    <i class="fas fa-user"></i>
                                    <a
                                        class="underline"
                                        href="/users/{{$post->user->id}}"
                                    >{{ $post->user->name }}</a>
                                    • {{ $post->created_at->diffForHumans() }}
                                </small>
                            </p>
                        </div>
                    </div>

                    <div class="right-side flex items-center space-x-2">
                        @if($post->isHot())
                            <i title="This post is trending." class="fas fa-fire text-orange-400"></i>
                        @endif

                        <p class="text-sm text-gray-600">{{$post->comments_count}} <i class="fas fa-comments text-gray-400"></i></p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-container>
</x-master>
