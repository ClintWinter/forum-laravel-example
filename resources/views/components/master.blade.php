<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="data:,">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <livewire:styles>

    <title>Forum App</title>
</head>
<body class="font-sans">
    <div class="shadow">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="font-black text-lg text-indigo-600"><a href="/posts">ForumApp</a></h1>

            @error('throttle:actions')
                <div class="bg-red-100 border border-red-600 rounded text-red-700">{{ $errors->first('throttle:actions') }}</div>
            @enderror

            <div class="flex items-center space-x-4">
                @auth
                    @if (auth()->user()->notifications()->exists())
                        <livewire:notifications />
                    @endif
                    <div class="mr-4 text-sm">Active: {{ auth()->user()->name }}</div>
                @else
                    <x-link-primary type="link" href="/register">Register</x-link-primary>
                @endauth

                <div x-data="{open:false}" class="relative">
                    <button class="cursor-pointer" @click="open=true">Switch User <i class="fas fa-chevron-down ml-2"></i></button>

                    <div class="absolute w-40 py-2 px-4 bg-white shadow rounded right-0 mt-2 border border-gray-200" x-cloak x-show="open" @click.away="open=false">
                        @foreach ($switchableUsers as $user)
                            <form class="pb-1 border-b border-gray-100 last:border-b-0" method="POST" action="/switch-user">
                                @csrf
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <button type="submit" class="leading-none text-xs text-blue-500 hover:underline">{{ $user->name }}</button>
                            </form>
                        @endforeach

                        @auth
                            <x-form-button class="w-full" action="/logout" method="POST"><button type="submit" class="w-full font-bold text-center mt-2 text-blue-500 hover:underline cursor-pointer">Log Out</button></x-form-button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $slot }}

    <livewire:scripts>
    <script src="/js/app.js"></script>
    <script src="/js/all.min.js"></script>
</body>
</html>
