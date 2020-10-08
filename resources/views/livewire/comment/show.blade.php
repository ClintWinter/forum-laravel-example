<div 
    class="border border-gray-300 p-1 mt-2 border-l-4 rounded-sm {{$comment->trashed() ? 'bg-gray-100' : 'bg-white'}}" 
    x-data="{ replying: false, collapsed: false, confirmDelete: false }"
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

    <div class="h-4" x-show="! collapsed"></div>

    {{-- score + body --}}
    <div class="flex" x-show="! collapsed">
        <livewire:comment-reaction :comment="$comment">

        {{-- post body --}}
        <div class="flex-grow">
            <div>
                <div class="h-4"></div>
                
                @if($comment->trashed())
                    <p>[Deleted]</p>
                @else
                    <p>{{$comment->body}}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- bottom line --}}
    @if(! $comment->trashed())
        <div x-show="! collapsed">
            <div class="h-4"></div>

            <div class="flex space-x-2 text-xs text-gray-500">
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

                            <div 
                                class="text-base border-l-4 border-yellow-300 px-4 py-2 mb-4"
                            >{{ $comment->body }}</div>

                            <form wire:submit.prevent="addComment">
                                <textarea 
                                    name="body" 
                                    placeholder="Comment..."
                                    wire:model.defer="body"
                                    class="resize-y border border-gray-300 w-full h-32 p-2 max-h-64"
                                ></textarea>

                                <input type="hidden" name="parent_id" wire:model.defer="parent_id" value="">
                                
                                <div class="h-8"></div>
                                
                                <div class="flex justify-end">
                                    <x-btn.link 
                                        class="mr-4" 
                                        type="button" 
                                        @click="open = false"
                                    >Cancel</x-btn.link>
                                    
                                    <x-btn.primary 
                                        type="submit" 
                                        @click="open = false"
                                    >Post comment</x-btn.primary>
                                </div>
                            </form>
                        </div>
                    </x-modal>
                @endauth

                {{-- delete --}}
                @can('delete', $comment)
                    <div>
                        <x-btn.link 
                            class="underline" 
                            @click="confirmDelete = true" 
                            x-show="!confirmDelete"
                        >Delete</x-btn.link>

                        <div x-show="confirmDelete" x-cloak>
                            Are you sure? 
                            <x-form-button 
                                class="underline" 
                                action="/posts/{{$post->id}}/comments/{{$comment->id}}"
                                method="DELETE"
                            ><x-btn.link class="underline">Yes</x-btn.link></x-form-button>
                            <x-btn.link type="button" @click="confirmDelete = false" class="underline">No</x-btn.link>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    @endif
    
    {{-- nested comment list --}}
    <div x-show="! collapsed">
        <x-comment.list class="mt-4" :post="$post" :comments="$comments" :comment-id="$comment->id" />
    </div>
</div>