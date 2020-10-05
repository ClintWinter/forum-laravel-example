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
                @auth
                    <x-btn.link 
                        class="underline" 
                        @click="replying = true"
                    >Reply</x-btn.link>
                @endauth

                @can('delete', $comment)
                    <div>
                        <x-btn.link 
                            class="underline" 
                            @click="confirmDelete = true" 
                            x-show="!confirmDelete"
                        >Delete</x-btn.link>

                        <div x-show="confirmDelete">
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

            {{-- post comment --}}
            <div 
                x-show="replying" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform origin-top scale-90 -translate-y-4"
                x-transition:enter-end="opacity-100 transform origin-top scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform origin-top scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 transform origin-top scale-90 -translate-y-4"
                class="bg-gray-100 border border-gray-300 rounded-sm p-4 mt-4"
            >
                <form action="/posts/{{$post->id}}/comments" method="POST">
                    @csrf

                    <textarea 
                        name="body" 
                        placeholder="Comment..."
                        class="resize-y border border-gray-300 w-full h-32 p-2"
                    ></textarea>

                    <input type="hidden" name="parent_id" value="{{$comment->id}}">
                    
                    <div class="h-8"></div>
                    
                    <div class="flex justify-end">
                        <x-btn.link class="mr-4" type="button" @click="replying = false">Cancel</x-btn.link>
                        <x-btn.primary type="submit">Post comment</x-btn.primary>
                    </div>
                </form>
            </div>
        </div>
    @endif

    
    {{-- new comment + comments --}}
    <div x-show="! collapsed">
        {{-- comments --}}
        @if(isset($comments[$comment->id]))
            <div class="mt-4">
                @foreach($comments[$comment->id] as $nestedComment)
                    <x-comment.list-item 
                        :post="$post"
                        :comments="$comments" 
                        :comment="$nestedComment"
                    ></x-comment.list-item>
                @endforeach
            </div>
        @endif
    </div>
</div>