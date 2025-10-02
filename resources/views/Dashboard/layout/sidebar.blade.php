<aside class="hidden w-64 h-screen bg-white shadow-md lg:block">
    <div class="p-6 lg:p-10">
        <h2 class="mb-6 text-2xl font-semibold text-indigo-600">Menu</h2>
        <nav class="space-y-4">
            @auth
                @if(auth()->user()->role->name == 'admin')
                    <a href="/dashboard" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Dashboard</a>
                    <a href="{{ route('Dashboard.manager.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Manager</a>
                    <a href="{{ route('Dashboard.restoran.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Restoran</a>
                    <a href="{{ route('Dashboard.menu.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Menu Restoran</a>
                    <a href="{{ route('Dashboard.table.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Table</Table></a>
                    <a href="{{ route('Dashboard.customer.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Customer</a>
                    <a href="{{ route('Dashboard.loyalty.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Loyalty</a>
                @elseif(auth()->user()->role->name == 'manager')
                    <a href="{{ route('Dashboard.manager.index') }}" class="block px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">Dashboard Manager</a>
                    {{-- tambahkan menu khusus manager di sini --}}
                @endif
            @endauth
        </nav>
    </div>
</aside>
