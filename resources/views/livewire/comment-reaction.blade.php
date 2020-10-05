<div class="w-10 flex flex-col items-center">
    <x-btn.link wire:click="upvote">
        <i class="fas fa-chevron-up {{ $this->comment->hasReactionFrom(Auth::user(), 1) ? 'text-green-500' : '' }}"></i>
    </x-btn.link>

    {{ $this->comment->score() }}

    <x-btn.link wire:click="downvote">
        <i class="fas fa-chevron-down {{ $this->comment->hasReactionFrom(Auth::user(), -1) ? 'text-orange-500' : '' }}"></i>
    </x-btn.link>
</div>