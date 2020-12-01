<div>
    <div class="flex mb-8 border-b-4 border-gray-300">
        <div class="px-6 py-2 -mb-1 text-xl border-b-4 cursor-pointer {{ $activeTab === 'reactables' ? 'border-indigo-600 text-indigo-600' : 'border-gray-300 text-gray-600' }}" wire:click="setTab('reactables')">
            Comments &amp; Posts
        </div>
        <div class="px-6 py-2 -mb-1 text-xl border-b-4 cursor-pointer {{ $activeTab === 'reactions' ? 'border-indigo-600 text-indigo-600' : 'border-gray-300 text-gray-600' }}" wire:click="setTab('reactions')">
            Reactions
        </div>
    </div>

    <div class="mb-16">
        @if ($activeTab === 'reactables')
            <livewire:user.reactables :user="$user" />
        @elseif ($activeTab === 'reactions')
            <livewire:user.reactions :user="$user" />
        @endif
    </div>
</div>
