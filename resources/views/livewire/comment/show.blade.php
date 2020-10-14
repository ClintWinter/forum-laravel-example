<div
    class="border border-gray-300 p-1 mt-2 border-l-4 rounded-sm {{$comment->trashed() ? 'bg-gray-100' : 'bg-white'}}"
    x-data="{ collapsed: false, confirmDelete: false, editing: false }"
>
    {{-- headline --}}
    <div class="flex justify-between text-xs">
        <p class="text-gray-700 flex items-center space-x-2">
            <i class="fas fa-user text-lg"></i>
            <span class="font-bold text-gray-900 text-sm mr-1">{{$comment->user->name}}</span>
            <span>{{$comment->created_at->diffForHumans()}}</span>
        </p>

        <div>
            <x-btn.link @click="collapsed = true" x-show="! collapsed">[-]</x-btn.link>
            <x-btn.link @click="collapsed = false" x-show="collapsed">[+]</x-btn.link>
        </div>
    </div>

    {{-- score + body --}}
    <div class="flex mt-4" x-show="! collapsed">
        {{-- score --}}
        @if(auth()->check() && ! $comment->trashed())
            <div class="w-10 flex flex-col items-center">
                <x-btn.link wire:click="upvote">
                    <i class="fas fa-chevron-up {{ $this->comment->hasReactionFrom(auth()->user(), 1) ? 'text-green-500' : '' }}"></i>
                </x-btn.link>

                <span>{{ $this->comment->score() }}</span>

                <x-btn.link wire:click="downvote">
                    <i class="fas fa-chevron-down {{ $this->comment->hasReactionFrom(auth()->user(), -1) ? 'text-orange-500' : '' }}"></i>
                </x-btn.link>
            </div>
        @endif

        {{-- post body + edit form --}}
        <div class="flex-grow">
            <div class="pt-4" x-show="! editing">
                @if($comment->trashed())
                    <p>[Deleted]</p>
                @else
                    <p>{{$comment->body}}</p>
                @endif
            </div>

            @can('update', $comment)
                <div x-show="editing">
                    <textarea name="editBody" placeholder="Comment..." wire:model="comment.body" class="resize-y border border-gray-300 w-full h-32 p-2 mb-8 max-h-64"></textarea>

                    <div class="flex justify-end">
                        <x-btn.link class="mr-4" @click="editing = false" wire:click="$refresh()">Cancel</x-btn.link>
                        <x-btn.primary @click="editing = false" wire:click="editComment()">Save comment</x-btn.primary>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    {{-- bottom line --}}
    @if(! $comment->trashed())
        <div class="pt-4" x-show="! collapsed">
            <div class="flex space-x-2 text-xs text-gray-500">
                @can('update', $comment)
                    <x-btn.link class="underline" @click="editing = true">Edit</x-btn.link>
                @endcan

                {{-- reply --}}
                @auth
                    <x-modal>
                        <x-slot name="trigger">
                            <x-btn.link
                                class="underline"
                                @click="open = true"
                            >Reply</x-btn.link>
                        </x-slot>

                        {{-- add comment form --}}
                        <div>
                            <h1 class="text-xl mb-4">Replying to <b>{{ $comment->user->name }}</b></h1>

                            <div class="text-base border-l-4 border-yellow-300 px-4 py-2 mb-4">{{ $comment->body }}</div>

                            <form wire:submit.prevent="addComment">
                                <textarea name="reply" placeholder="Comment..." wire:model.defer="reply" class="resize-y border border-gray-300 w-full h-32 p-2 max-h-64 mb-8"></textarea>

                                <div class="flex justify-end">
                                    <x-btn.link class="mr-4" type="button" @click="open = false">Cancel</x-btn.link>
                                    <x-btn.primary type="submit" @click="open = false" >Post comment</x-btn.primary>
                                </div>
                            </form>
                        </div>
                    </x-modal>
                @endauth

                {{-- delete --}}
                @can('delete', $comment)
                    <div>
                        <x-btn.link class="underline" @click="confirmDelete = true" x-show="!confirmDelete">Delete</x-btn.link>

                        <div x-show="confirmDelete" x-cloak>Are you sure?
                            <x-btn.link wire:click="deleteComment" @click="confirmDelete = false" class="underline">Yes</x-btn.link>
                            <x-btn.link type="button" @click="confirmDelete = false" class="underline">No</x-btn.link>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    @endif

    {{-- nested comment list --}}
    <x-comment.list x-show="! collapsed" class="mt-4" :comments="$replies" />
</div>
