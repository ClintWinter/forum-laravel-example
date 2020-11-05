<div x-data="{open:false}" class="relative" @click.away="if(open)$wire.clearNotifications(); open=false;">
    <button @click="open = !open; if(!open) $wire.clearNotifications();" class="relative">
        @if (auth()->user()->unreadNotifications()->exists())
            <div class="bg-red-600 rounded-full h-3 w-3 absolute top-0 right-0 shadow"></div>
        @endif
        <i class="text-2xl cursor-pointer fas fa-bell"></i>
    </button>

    <div x-show="open" x-cloak class="absolute top-10 right-0 bg-white border border-gray-200 rounded shadow overflow-y-auto" style="max-height:32rem; width:25rem;">

        @foreach(auth()->user()->notifications as $notification)
            <a class="block hover:bg-gray-100 py-4 px-2 {{ $notification->read_at ? 'opacity-50' : 'border-l-4 border-blue-400' }}" href="/posts/{{ $notification->data['comment']['post_id'] }}#Comment{{ $notification->data['comment']['id'] }}" @click="open=false; $wire.clearNotifications();" style="border-bottom: 1px solid #f7fafc;">
                <p class="leading-none text-xs {{ ! $notification->read_at ? 'mb-4' : '' }}"><b>{{ \App\Models\User::find($notification->data['comment']['user_id'])->name }}</b> replied to your comment <b>{{ \Illuminate\Support\Carbon::parse($notification->data['comment']['created_at'])->diffForHumans() }}</b></p>

                @if(! $notification->read_at)
                    <blockquote class="text-sm leading-tight text-gray-500 italic">"{{ \Str::limit($notification->data['comment']['body'], 100) }}"</blockquote>
                @endif
            </a>
        @endforeach

    </div>
</div>
