<div 
    class="border border-gray-300 p-1 mt-2 border-l-4 rounded-sm {{$comment->trashed() ? 'bg-gray-100' : 'bg-white'}}" 
    x-data="{ replying: false }"
>
    <p class="text-gray-500 text-xs">
        <i class="fas fa-user"></i>
        <span>{{$comment->user->name}}</span>
        •
        <span>{{$comment->created_at->format('n/j/Y g:i A')}}</span>
    </p>

    <div class="h-4"></div>
    
    @if($comment->trashed())
        <p>[Deleted]</p>
    @else
        <p>{{$comment->body}}</p>
    @endif

    <div class="h-4"></div>

    @if(! $comment->trashed())
        <div class="space-x-2 text-xs text-gray-500">
            @auth
                <x-btn.link 
                    class="underline" 
                    @click="replying = true"
                >Reply</x-btn.link>
            @endauth

            @can('delete', $comment)
                <x-form-button 
                    class="underline" 
                    @click="replying = true"
                    action="/posts/{{$post->id}}/comments/{{$comment->id}}"
                    method="DELETE"
                ><x-btn.link class="underline">Delete</x-btn.link></x-form-button>
            @endcan
        </div>
    @endif

    <div class="h-4"></div>

    <div 
        x-show="replying" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform origin-top scale-90 -translate-y-4"
        x-transition:enter-end="opacity-100 transform origin-top scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform origin-top scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 transform origin-top scale-90 -translate-y-4"
        class="bg-gray-100 border border-gray-300 rounded-sm p-4"
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

    @if(isset($comments[$comment->id]))
        <div>
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