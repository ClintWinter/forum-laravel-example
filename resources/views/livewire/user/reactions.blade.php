<div>
    <div class="py-2 rounded-sm bg-white shadow">
        @foreach($reactions as $reaction)
            <div class="p-4 border-b-2 border-gray-100 last:border-b-0">
                <div class="mb-8 flex items-center">
                    <span class="text-xl fa-stack leading-none">
                        <i class="fas fa-square fa-stack-2x text-gray-100"></i>
                        <i class="far fa-square fa-stack-2x text-gray-200"></i>
                        <i class="fas fa-user fa-stack-1x text-gray-400"></i>
                    </span>

                    <div class="flex flex-col leading-none">
                        <p class="text-sm text-gray-700 mb-1">
                            <x-link href="{{ $reaction->reactable->user->path() }}" class="mr-2">
                                {{ $reaction->reactable->user->name }}
                            </x-link>
                        </p>
                        <p class="text-xs text-gray-400">
                            @if(class_basename($reaction->reactable) === 'Comment')
                                <i class="text-gray-300 fas fa-comment"></i>
                            @elseif(class_basename($reaction->reactable) === 'Post')
                                <i class="text-gray-300 fas fa-quote-left"></i>
                            @endif

                            <span>
                                {{ class_basename($reaction->reactable) }}ed {{ $reaction->reactable->created_at->diffForHumans() }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mb-8 flex justify-between items-start">
                    <p class="text-gray-700">
                        {{ Str::limit($reaction->display, 50) }}
                    </p>
                </div>

                <p class="text-sm text-gray-500">
                    @if($reaction->value === 1)
                        <i class="text-green-500 fas fa-chevron-circle-up"></i>
                    @elseif($reaction->value === -1)
                        <i class="text-red-600 fas fa-chevron-circle-down"></i>
                    @endif

                    <span>
                        {{ ($reaction->value === 1 ? 'Liked ' : 'Disliked ').$reaction->created_at->diffForHumans() }}
                    </span>
                </p>
            </div>
        @endforeach
    </div>
</div>
