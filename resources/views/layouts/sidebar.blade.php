<div class="w-64 bg-white shadow-md h-screen flex flex-col justify-between">
    <div>
        <div class="p-4 border-b">
            <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
        </div>

        <ul class="p-4 space-y-2">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 hover:bg-gray-200 rounded">Home</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.menu.index') }}"
                   class="block px-4 py-2 hover:bg-gray-200 rounded">Menu</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.customer.index') }}"
                   class="block px-4 py-2 hover:bg-gray-200 rounded">Customer</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.manager.index') }}"
                   class="block px-4 py-2 hover:bg-gray-200 rounded">Manager</a>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-left text-red-600 hover:bg-red-100 rounded px-4 py-2">
                Logout
            </button>
        </form>
    </div>
</div>
