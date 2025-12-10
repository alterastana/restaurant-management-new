<div :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
     class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 
            transform transition duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl">
    
    <!-- Header Sidebar -->
    <div class="flex items-center justify-between px-6 py-4 bg-brand-red">
        <div class="text-xl font-bold text-white tracking-wider">RestoApp Dashboard</div>
        <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded-full text-white hover:bg-brand-red-hover transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <!-- Navigasi Menu -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        
        <!-- Fungsi untuk menentukan kelas styling -->
        @php
            // Class default untuk semua link
            $linkClass = 'flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-brand-orange hover:text-white transition group';
            // Class aktif
            $activeClass = 'bg-brand-red text-white font-semibold shadow-md';
            // Fungsi untuk memeriksa apakah rute aktif
            $isActive = fn($routes) => is_array($routes) ? request()->routeIs(...$routes) : request()->routeIs($routes);
        @endphp

        <!-- Home / Dashboard (Semua bisa akses) -->
        <a href="{{ route('dashboard') }}" 
           class="{{ $linkClass }} {{ $isActive('dashboard') ? $activeClass : 'hover:bg-gray-100' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-7-7-7 7m14 0v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Home
        </a>

        @auth
            <!-- Menu & Table (Admin, Manager, Kasir) -->
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('cashier'))
                <a href="{{ route('Dashboard.menu.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.menu.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Menu
                </a>
                <a href="{{ route('Dashboard.table.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.table.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Meja (Table)
                </a>
            @endif

            <!-- Reservasi (Admin & Kasir) -->
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('cashier'))
                <a href="{{ route('Dashboard.reservation.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.reservation.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M12 21h4a2 2 0 002-2V7a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a2 2 0 002 2zm-7 0h.01M7 21h.01M17 11h.01M17 15h.01"></path></svg>
                    Reservasi
                </a>
            @endif

            <!-- Order & Payment (Admin, Manager, Kasir) -->
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('cashier'))
                <a href="{{ route('Dashboard.order.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.order.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M10 12h.01"></path></svg>
                    Order
                </a>
                <a href="{{ route('Dashboard.payment.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.payment.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 2h.01M17 9h2a2 2 0 012 2v6a2 2 0 01-2 2h-6a2 2 0 01-2-2v-6a2 2 0 012-2h2m-4 0h.01"></path></svg>
                    Payment
                </a>
            @endif

            <!-- Customer & Loyalty & Restoran (Admin & Manager) -->
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                <a href="{{ route('Dashboard.restoran.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.restoran.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    Restoran
                </a>
                <a href="{{ route('Dashboard.customer.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.customer.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H4v-2a3 3 0 015-2.236M9 20v-2M5 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Customer
                </a>
                <a href="{{ route('Dashboard.loyalty.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.loyalty.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.871a2 2 0 00-1.996 0L2.87 7.022A2 2 0 002 8.718v6.564a2 2 0 00.871 1.777l6.183 4.15a2 2 0 001.996 0l6.183-4.15a2 2 0 00.871-1.777V8.718a2 2 0 00-.871-1.777l-6.183-4.15zM12 11V8M12 18v-3"></path></svg>
                    Loyalty
                </a>
            @endif

            <!-- Manajemen User / Manager (Hanya Admin) -->
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('Dashboard.users.index') }}" 
                   class="{{ $linkClass }} {{ $isActive('Dashboard.users.*') ? $activeClass : 'hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354c.325.3.83 1.127 1.637 2.175A11.97 11.97 0 0021 10.3c-.764 1.18-1.55 2.185-2.27 2.943a3 3 0 01-1.8 1.134l-1.92.348a1 1 0 00-.91.597l-.27.81c-.2.6-.45 1.18-.75 1.74a1 1 0 01-1.07.56l-1.5-.15a1 1 0 00-.92.21l-1.2.96a1 1 0 01-1.2.03l-1.5-.9a1 1 0 00-.9-.05l-1.5.3a1 1 0 01-1.12-.22l-.42-.64a1 1 0 00-.9-.35l-1.5-.15a1 1 0 01-1.12-.22L3.5 15.2c-.42-.5-.77-1.05-1.05-1.63a11.97 11.97 0 00-1.45-2.58C1.5 10.3 2.29 9.295 3.054 8.115A11.97 11.97 0 0110.363 6.53c.807-1.048 1.312-1.875 1.637-2.175z"></path></svg>
                    Manager (Users)
                </a>
            @endif
        @endauth
    </nav>

    <!-- Footer Logout -->
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left flex items-center justify-center px-4 py-2 bg-brand-red hover:bg-brand-red-hover text-white rounded-lg transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</div>