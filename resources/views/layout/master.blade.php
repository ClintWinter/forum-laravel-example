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

    @yield('main')    

    @livewireScripts
    <script src="/js/app.js"></script>
    <script src="/js/all.min.js"></script>
</body>
</html>