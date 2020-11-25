<x-master>

    <div class="container mx-auto py-20 px-2">
        <x-page-header class="mb-12">Users</x-page-header>

        <div class="flex items-stretch flex-wrap">
            @foreach($users as $user)
                <div class="p-2 w-1/3">
                    <div class="w-full p-4 rounded border border-gray-200 shadow-sm flex justify-between">
                        <div class="text-blue-600 hover:underline">
                            <a href="{{ $user->path() }}">{{ $user->name }}</a>
                        </div>
                        <div class="font-bold">
                            {{ $user->score }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-master>
