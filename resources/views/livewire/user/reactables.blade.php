<div>
    <div class="text-sm text-gray-600 space-x-1 mb-4">
        <span>Sort by</span>
        <div class="inline-block relative" x-data="{open:false}">
            <button class="font-bold border-b-2 border-gray-600 border-dotted" @click="open=true" x-text="$wire.sortFieldList[$wire.sortField]"></button>

            <div class="w-32 bg-white text-sm rounded-sm shadow-lg absolute top-8 right-0" x-show.transition="open" @click.away="open=false" x-cloak>
                @foreach ($sortFieldList as $key => $display)
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortField', '{{ $key }}');">
                        {{ $display }}
                    </div>
                @endforeach
            </div>

            <input type="hidden" x-ref="sortField" wire:model="sortField">
        </div>
        <span>in</span>
        <button class="font-bold border-b-2 border-gray-600 border-dotted" wire:click="toggleSortDirection">{{ $sortDirectionList[$sortDirection] }}</button>
        <span>order</span>
    </div>

    <div class="py-2 rounded-sm bg-white shadow">
        @foreach($reactables as $reactable)
            <div class="p-4 border-b-2 border-gray-100 last:border-b-0">
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

                    <span>{{ class_basename($reactable) }}ed {{ $reactable->created_at->diffForHumans() }}</span>
                </p>
            </div>
        @endforeach
    </div>
</div>
