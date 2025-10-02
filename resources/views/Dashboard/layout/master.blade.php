<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">
        @include('Dashboard.layout.header')

        <div class="flex flex-1">
            @include('Dashboard.layout.sidebar')

            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
