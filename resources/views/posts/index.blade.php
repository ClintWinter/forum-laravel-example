<x-master>
    <div class="pt-8">
        <x-container class="flex justify-between">
            <x-page-header>Posts</x-page-header>

            @auth
                <x-link-primary href="/posts/new">New post</x-link-primary>
            @endauth
        </x-container>
    </div>

    <x-container class="pt-8">
        <div class="pt-4 flex justify-around flex-wrap items-stretch bg-white shadow rounded-sm">
            @foreach ($posts as $post)
                <div class="w-full px-4 pb-4 mb-4 flex items-center justify-between border-b-2 border-gray-100 last:border-b-0">
                    <div class="flex-grow">
                        <div class="flex items-start mb-6">
                            <span class="text-xl fa-stack leading-none">
                                <i class="fas fa-square fa-stack-2x text-gray-100"></i>
                                <i class="far fa-square fa-stack-2x text-gray-200"></i>
                                <i class="fas fa-user fa-stack-1x text-gray-400"></i>
                            </span>

                            <div class="flex flex-col leading-none">
                                <p class="text-sm text-gray-700 mb-1">
                                    <x-link href="{{ $post->user->path() }}" class="mr-2">{{ $post->user->name }}</x-link>
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <h2 class="text-lg font-bold text-gray-800 leading-none" title="{{ \Str::limit($post->body, 100) }}">
                            <x-link href="/posts/{{ $post->id }}">{{ $post->title }}</x-link>
                        </h2>
                    </div>

                    <div class="mr-4">
                        @if($post->isHot())
                            <i title="This post is trending." class="fas fa-fire text-orange-500"></i>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center w-20 space-y-2">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-comments text-gray-400"></i>
                            {{$post->comments_count}}
                        </p>

                        <p class="text-sm text-gray-600">
                            <i class="fas fa-eye text-gray-400"></i>
                            {{ $views[$post->id] ?? 0 }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-container>
</x-master>
