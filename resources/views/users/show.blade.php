<x-master>
    <div class="h-64 bg-indigo-600 shadow-inner"></div>

    <div class="container mx-auto py-12 px-2">
        <div class="mb-12">
            <h1 class="text-4xl font-bold mb-8">
                {{ $user->name }}
            </h1>

            <div class="flex items-center justify-between bg-white rounded-sm shadow px-8 py-16">
                <div class="w-1/3 flex flex-col items-center">
                    <span class="text-3xl font-bold text-black">{{ $user->score() }}</span>
                    <span class="text-base text-gray-500">Score</span>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <span class="text-3xl font-bold text-black">{{ $user->posts()->count() }}</span>
                    <span class="text-base text-gray-500">Posts</span>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <span class="text-3xl font-bold text-black">{{ $user->comments()->count() }}</span>
                    <span class="text-base text-gray-500">Comments</span>
                </div>
            </div>
        </div>

        {{-- menu --}}
        <livewire:user.show :user="$user" />
    </div>
</x-master>
