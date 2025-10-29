<div class="w-64 sidebar-root shadow-md h-screen flex flex-col justify-between">
    <div>
        <div class="p-4 border-b">
            <h1 class="text-xl sidebar-title">{{ config('app.name') }}</h1>
        </div>

        <ul class="p-4 space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 sidebar-link rounded">Home</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.menu.index') }}" class="block px-4 py-2 sidebar-link rounded">Menu</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.customer.index') }}" class="block px-4 py-2 sidebar-link rounded">Customer</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.manager.index') }}" class="block px-4 py-2 sidebar-link rounded">Manager</a>
            </li>
            <li>
                <a href="{{ route('Dashboard.loyalty.index') }}" class="block px-4 py-2 sidebar-link rounded">Loyalty</a>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left btn-secondary">
                Logout
            </button>
        </form>
    </div>
</div>