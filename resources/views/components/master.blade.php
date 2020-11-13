<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="data:,">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <livewire:styles>

    <title>Forum App</title>
</head>
<body>
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

                    <x-form-button action="/logout" method="POST"><x-btn.secondary type="submit">{{ auth()->user()->name }}</x-btn.secondary></x-form-button>
                @else
                    <x-link type="link" href="/login">Log in</x-link>
                    <x-link-primary type="link" href="/register">Register</x-link-primary>
                @endauth
            </div>
        </div>
    </div>

    {{ $slot }}

    <livewire:scripts>
    <script src="/js/app.js"></script>
    <script src="/js/all.min.js"></script>
</body>
</html>
