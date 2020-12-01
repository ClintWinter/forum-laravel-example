<div>
    <div class="px-2 mb-8 flex items-center">
        <div class="text-sm text-gray-600 space-x-1">
            <span>Sort by</span>
            <div class="inline-block relative" x-data="{open:false}">
                <button class="font-bold border-b-2 border-gray-600 border-dotted" @click="open=true" x-text="$wire.sortFieldList[$wire.sortField]"></button>

                <div class="bg-white text-sm rounded-sm shadow-lg absolute top-8 right-0" x-show.transition="open" @click.away="open=false" x-cloak>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortField', 'score'); $wire.sort();">
                        Score
                    </div>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortField', 'posts_count'); $wire.sort();">
                        Posts
                    </div>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortField', 'comments_count'); $wire.sort();">
                        Comments
                    </div>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortField', 'name'); $wire.sort();">
                        Name
                    </div>
                </div>

                <input type="hidden" x-ref="sortField" wire:model="sortField">
            </div>
            <span>in</span>
            <div class="inline-block relative" x-data="{open:false}">
                <button class="font-bold border-b-2 border-gray-600 border-dotted"  @click="open=true" x-text="$wire.sortDirectionList[$wire.sortDirection]"></button>

                <div class="bg-white text-sm rounded-sm shadow-lg absolute top-8 right-0" x-show.transition="open" @click.away="open=false" x-cloak>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortDirection', 'desc'); $wire.sort();">
                        descending
                    </div>
                    <div class="p-2 text-gray-600 border-b-2 border-gray-100 last:border-b-0 cursor-pointer hover:text-gray-900" @click="open=false; $wire.set('sortDirection', 'asc'); $wire.sort();">
                        ascending
                    </div>
                </div>
            </div>
            <span>order</span>
        </div>
    </div>

    <div class="flex items-stretch flex-wrap">
        @foreach($users as $user)
            <div class="p-2 w-1/3">
                <div class="w-full p-4 bg-white rounded-sm shadow">
                    <div class="text-lg text-gray-800 hover:underline mb-4">
                        <a href="{{ $user->path() }}">{{ $user->name }}</a>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex flex-col items-center">
                            <span class="text-gray-600 font-bold text-lg">{{ $user->score }}</span>
                            <span class="text-xs text-gray-500">Score</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-gray-600 font-bold text-lg">{{ $user->posts_count }}</span>
                            <span class="text-xs text-gray-500">Posts</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-gray-600 font-bold text-lg">{{ $user->comments_count }}</span>
                            <span class="text-xs text-gray-500">Comments</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
