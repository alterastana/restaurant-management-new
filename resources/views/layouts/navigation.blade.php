<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('Dashboard.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('Dashboard.index')" :active="request()->routeIs('Dashboard.index')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Tampilkan menu jika user adalah admin atau manager --}}
                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                        <x-nav-link :href="route('Dashboard.restoran.index')" :active="request()->routeIs('Dashboard.restoran.*')">
                            {{ __('Restoran') }}
                        </x-nav-link>

                        <x-nav-link :href="route('Dashboard.menu.index')" :active="request()->routeIs('Dashboard.menu.*')">
                            {{ __('Menu') }}
                        </x-nav-link>
                    @endif

                    {{-- ===== Tambahan Menu ORDER ===== --}}
                    <x-nav-link :href="route('order.index')" :active="request()->routeIs('order.*')">
                        {{ __('Order') }}
                    </x-nav-link>

                    {{-- ===== Tambahan Menu RESERVATION ===== --}}
                    <x-nav-link :href="route('reservation.index')" :active="request()->routeIs('reservation.*')">
                        {{ __('Reservation') }}
                    </x-nav-link>

                    {{-- ===== Tambahan Menu PAYMENT ===== --}}
                    <x-nav-link :href="route('payment.index')" :active="request()->routeIs('payment.*')">
                        {{ __('Payment') }}
                    </x-nav-link>

                    {{-- Menu hanya untuk admin --}}
                    @if (Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('Dashboard.manager.index')" :active="request()->routeIs('Dashboard.manager.*')">
                            {{ __('Users') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10..." />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Responsive Mobile Menu Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('Dashboard.index')" :active="request()->routeIs('Dashboard.index')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Tambahan menu versi mobile -->
            <x-responsive-nav-link :href="route('order.index')" :active="request()->routeIs('order.*')">
                {{ __('Order') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reservation.index')" :active="request()->routeIs('reservation.*')">
                {{ __('Reservation') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('payment.index')" :active="request()->routeIs('payment.*')">
                {{ __('Payment') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
