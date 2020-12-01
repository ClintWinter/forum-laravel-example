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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <livewire:styles>

    <title>Forum App</title>
</head>
<body class="font-sans bg-gray-100">
    <div class="bg-white shadow">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="font-black text-lg text-indigo-800"><a href="/posts">ForumApp</a></h1>

            <div class="flex items-center justify-center">
                <x-link href="/users">Users</x-link>
            </div>

            <div class="flex items-center space-x-8">
                @auth
                    @if (auth()->user()->notifications()->exists())
                        <livewire:notifications />
                    @endif
                @else
                    <x-link-primary type="link" href="/register">Register</x-link-primary>
                @endauth

                <div x-data="{open:false}" class="relative">
                    <button class="text-xl cursor-pointer" @click="open=true">
                        @auth
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                        @endauth
                        <span class="fa-stack">
                            <i class="fas fa-square fa-stack-2x text-gray-100"></i>
                            <i class="far fa-square fa-stack-2x text-gray-200"></i>
                            <i class="fas fa-user fa-stack-1x text-gray-400"></i>
                        </span>
                        <span class="text-gray-600"><i class="fas fa-chevron-down"></i></span>
                    </button>

                    <div class="absolute w-40 py-2 px-4 bg-white shadow rounded right-0 mt-2 border border-gray-200" x-cloak x-show.transition="open" @click.away="open=false">
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
