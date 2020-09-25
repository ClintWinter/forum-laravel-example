<x-master>
    <x-container>
        <div class="h-8"></div>

        <div class="flex justify-between items-center">
            <h1 class="text-2xl uppercase tracking-widest text-gray-600 font-thin">Posts</h1>
            
            @auth
                <x-link-primary href="/posts/new">New post</x-link-primary>
            @endauth
        </div>

        <div class="h-8"></div>

        <div class="flex justify-around flex-wrap items-stretch">
            @foreach ($posts as $post)
                <div class="w-full p-4 mb-4 border border-gray-300 rounded">
                    <h2 class="font-bold leading-none">
                        <x-link href="/posts/{{$post->id}}">{{ $post->title }}</x-link>
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
    </x-container>
</x-master>