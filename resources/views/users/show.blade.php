<x-master>
    <div class="h-64 bg-indigo-600 shadow-inner"></div>

    <div class="container mx-auto py-12 px-2">
        <div class="mb-12">
            <h1 class="text-4xl font-bold mb-4">{{ $user->name }}</h1>
            <p class="text-sm text-gray-600"><span class="text-base font-bold text-black">{{ $user->score() }}</span> Score</p>
        </div>

        <div class="py-2 border border-gray-300">
            @foreach($user->reactables() as $reactable)
                <div class="p-4 mb-4 border-b border-gray-200 last:border-b-0">
                    <div class="mb-2 flex justify-between items-start">
                        <p class="text-gray-700">
                            {{ Str::limit($reactable->display, 50) }}
                        </p>
                        <p class="text-xl mr-4 {{ $reactable->reactions_sum_value >= 0 ? 'text-green-500' : 'text-red-700' }}">
                            {{ $reactable->reactions_sum_value >= 0 ? '+'.($reactable->reactions_sum_value ?: 0) : $reactable->reactions_sum_value }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-500">
                        @if(class_basename($reactable) === 'Comment')
                            <i class="text-gray-400 fas fa-comment"></i>
                        @elseif(class_basename($reactable) === 'Post')
                            <i class="text-gray-400 fas fa-quote-left"></i>
                        @endif

                        <span class="mr-2">{{ class_basename($reactable) }}</span>
                        <span class="text-xs">{{ $reactable->created_at->diffForHumans() }}</span>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</x-master>
