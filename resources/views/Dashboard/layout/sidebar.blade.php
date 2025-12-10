<!-- TOMBOL HAMBURGER -->
<button @click="sidebarOpen = true" 
        class="fixed top-4 left-4 z-40 lg:hidden p-2 rounded-lg bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-50">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Overlay Mobile -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" 
     x-cloak>
</div>

<!-- SIDEBAR -->
<aside 
    class="fixed inset-y-0 left-0 z-30 w-72 bg-white shadow-lg transform transition-transform duration-300 
           lg:translate-x-0 lg:static lg:inset-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
    x-cloak
>
    <div class="flex flex-col h-full">
        <div class="flex-grow overflow-y-auto p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold tracking-tight sidebar-title">
                    {{ config('app.name') }}
                </h2>

                <button @click="sidebarOpen = false" 
                        class="lg:hidden text-gray-500 hover:text-gray-700 p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- NAVIGATION -->
            <nav class="space-y-2">

                @auth

                <!-- DASHBOARD -->
                <a href="{{ route('dashboard') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                        @if(request()->routeIs('dashboard')) bg-brand-primary text-white 
                        @else sidebar-link hover:bg-gray-100 @endif">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 12l2-2 7-7 7 7-2 2v10a1 1 0 01-1 1h-3v-4a1 1 0 00-1-1h-2a1 1 0 00-1 1v4H6a1 1 0 01-1-1V12z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- LOYALTY -->
                <a href="{{ route('Dashboard.loyalty.index') }}" 
                    class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                        @if(request()->routeIs('Dashboard.loyalty.*')) bg-brand-primary text-white 
                        @else sidebar-link hover:bg-gray-100 @endif">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 3v4m-2-2h4M6 17v4m-2-2h4m5-12v4m-2-2h4m5 4v4m-2-2h4"/>
                    </svg>
                    <span>Loyalty</span>
                </a>

                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))

                    <!-- RESTORAN -->
                    <a href="{{ route('Dashboard.restoran.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.restoran.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6h16v14H4zM9 10h6v10H9z"/>
                        </svg>
                        <span>Restoran</span>
                    </a>

                    <!-- MENU -->
                    <a href="{{ route('Dashboard.menu.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.menu.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span>Menu</span>
                    </a>

                    <!-- TABLE -->
                    <a href="{{ route('Dashboard.table.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.table.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 10h18v10H3zM3 6h18v4H3z"/>
                        </svg>
                        <span>Table</span>
                    </a>

                    <!-- CUSTOMER -->
                    <a href="{{ route('Dashboard.customer.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.customer.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
                        </svg>
                        <span>Customer</span>
                    </a>

                    <!-- ⭐ ORDER (BARU) -->
                    <a href="{{ route('Dashboard.order.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.order.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h18v4H3zm0 6h18v12H3z"/>
                        </svg>
                        <span>Order</span>
                    </a>

                    <!-- ⭐ RESERVATION (BARU) -->
                    <a href="{{ route('Dashboard.reservation.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.reservation.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3h8v4m-9 4h10m-9 4h9m-9 4h6"/>
                        </svg>
                        <span>Reservation</span>
                    </a>

                    <!-- ⭐ PAYMENT (BARU) -->
                    <a href="{{ route('Dashboard.order.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.payment.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 10h18v10H3zM3 4h18v4H3z"/>
                        </svg>
                        <span>Payment</span>
                    </a>

                @endif

                <!-- MANAGER (KHUSUS ADMIN) -->
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('Dashboard.manager.index') }}" 
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200
                            @if(request()->routeIs('Dashboard.manager.*')) bg-brand-primary text-white 
                            @else sidebar-link hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Manager</span>
                    </a>
                @endif

                @endauth

            </nav>
        </div>
    </div>
</aside>
<!-- END SIDEBAR -->