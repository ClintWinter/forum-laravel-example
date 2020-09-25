<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/all.min.css">
    @livewireStyles
    
    <title>Forum App</title>
</head>
<body>

    <div class="border-b border-gray-300">
        <div class="container mx-auto flex justify-between items-center p-4">
            <div>
                <h1 class="font-black text-lg text-indigo-600"><a href="/posts">ForumApp</a></h1>
            </div>

            <div>
                @auth
                    <form action="/logout" method="post">
                        @csrf
                        <x-btn.secondary type="submit">Log out</x-btn.secondary>
                    </form>
                @else
                    <x-link-secondary type="link" href="/login">Log in</x-link-secondary>
                @endauth
            </div>
        </div>
    </div>

    {{ $slot }}

    @livewireScripts
    <script src="/js/app.js"></script>
    <script src="/js/all.min.js"></script>
</body>
</html>