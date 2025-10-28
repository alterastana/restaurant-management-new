<!-- TOMBOL HAMBURGER - Letakkan di bagian atas halaman/navbar -->
<button @click="sidebarOpen = true" 
        class="fixed top-4 left-4 z-40 lg:hidden p-2 rounded-lg bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-50">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Overlay untuk mobile -->
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

<!-- Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-30 w-72 bg-white shadow-lg transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
    x-cloak
>
    <div class="flex flex-col h-full">
        <div class="flex-grow overflow-y-auto p-6">
            <!-- Header dengan tombol close untuk mobile -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-indigo-600 tracking-tight">RestoApp</h2>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="space-y-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('dashboard')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('Dashboard.loyalty.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.loyalty.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-12v4m-2-2h4m5 4v4m-2-2h4M17 3l-1.172 1.172a4 4 0 00-5.656 0L10 3m4 4l-1.172-1.172a4 4 0 00-5.656 0L6 7"></path></svg>
                        <span>Loyalty</span>
                    </a>

                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                        <a href="{{ route('Dashboard.restoran.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.restoran.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Restoran</span>
                        </a>
                        <a href="{{ route('Dashboard.menu.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.menu.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Menu</span>
                        </a>
                        <a href="{{ route('Dashboard.table.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.table.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span>Table</span>
                        </a>
                        <a href="{{ route('Dashboard.customer.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.customer.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Customer</span>
                        </a>
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('Dashboard.manager.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.manager.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Manager</span>
                        </a>

                        <a href="{{ route('Dashboard.users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.users.*')) bg-indigo-100 text-indigo-700 @else text-gray-600 hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Users</span>
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</aside>
