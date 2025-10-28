<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Dashboard') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        {{-- SIDEBAR KIRI --}}
        <aside class="w-64 bg-white border-r shadow-sm fixed top-0 left-0 h-screen">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-indigo-600">Menu</h2>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('Dashboard.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.index') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('Dashboard.manager.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.manager.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Manager
                </a>
                <a href="{{ route('Dashboard.restoran.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.restoran.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Restoran
                </a>
                <a href="{{ route('Dashboard.menu.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.menu.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Menu Restoran
                </a>
                <a href="{{ route('Dashboard.table.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.table.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Table
                </a>
                <a href="{{ route('Dashboard.customer.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.customer.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Customer
                </a>
                <a href="{{ route('Dashboard.loyalty.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-indigo-50 {{ request()->routeIs('Dashboard.loyalty.*') ? 'bg-indigo-100 font-semibold text-indigo-700' : '' }}">
                    Loyalty
                </a>
            </nav>
        </aside>

        {{-- BAGIAN KANAN (HEADER + ISI HALAMAN) --}}
        <div class="flex-1 ml-64 flex flex-col">

            {{-- HEADER / NAVBAR --}}
            <header class="bg-blue-600 text-white shadow flex justify-between items-center px-6 py-4">
                <h1 class="text-lg font-semibold">
                    {{ $pageTitle ?? 'Dashboard' }}
                </h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow">
                        Logout
                    </button>
                </form>
            </header>

            {{-- KONTEN HALAMAN --}}
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
