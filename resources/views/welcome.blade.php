<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roemah Kuliner — Restaurants makanan terbaik</title>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f3f4f6' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body x-data="menuApp()" x-init="init()" class="antialiased">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="brand-pill">
                <img src="{{ asset('images/logo.png') }}" class="logo">
                <span class="brand-text">Roemah Kuliner</span>
            </a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#menus">Order</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-pattern min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="animate__animated animate__fadeInLeft">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Selamat Datang Pengunjung Roemah Kuliner
                    </h1>
                    <p class="text-2xl text-gray-600 mb-8">
                        Temukan makanan dan minuman terbaik di Roemah Kuliner.
                    </p>
                    <h1 class="text-3xl text-green-600 font-semibold tracking-wide uppercase">
                        Anda di Meja Nomor {{ $tableNumber ?? '1' }}
                    </h1>

                    <h1 class="text-3xl text-green-600 font-semibold tracking-wide uppercase">
                        Kapasitas Meja {{ $capacity ?? 'Tidak Diketahui' }} Orang
                    </h1>



                </div>
                <div class="animate__animated animate__fadeInRight">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1470&q=80" 
                         alt="Restaurant Management" 
                         class="rounded-lg shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menus" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                
                <h2 class="text-4xl text-green-600 font-semibold tracking-wide uppercase">Menu</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Pilih menu makanan dan minuman
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Jelajahi berbagai jenis masakan dan hidangan dari restoran lokal terbaik.
                </p>
            </div>

            <div class="mt-10 grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @forelse($menus as $menu)
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $menu->name }}</h3>
                        <p class="mt-2 text-gray-600 flex-grow">{{ $menu->description }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <p class="text-lg font-bold" style="color: var(--brand);">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            <div class="mt-2">
                                <template x-if="!getCartItem({{ $menu->menu_id }})">
                                    <button @click="addToCart({{ json_encode($menu) }})" class="w-10 h-10 flex items-center justify-center px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-brand-primary hover:bg-brand-primary/90 transition">
                                        +
                                    </button>
                                </template>
                                <template x-if="getCartItem({{ $menu->menu_id }})">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button @click="updateQuantity({{ $menu->menu_id }}, -1)" class="w-10 h-10 flex items-center justify-center text-lg font-medium text-gray-600 hover:bg-gray-100 transition">-</button>
                                        <span x-text="getCartItem({{ $menu->menu_id }}).quantity" class="px-4 text-lg font-medium"></span>
                                        <button @click="updateQuantity({{ $menu->menu_id }}, 1)" class="w-10 h-10 flex items-center justify-center text-lg font-medium text-gray-600 hover:bg-gray-100 transition">+</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 col-span-full">No menus available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Sticky Cart Footer -->
    <div x-show="totalItems > 0" class="fixed bottom-0 left-0 right-0 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] p-4" style="display: none;" x-transition>
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>

                <div class="flex items-center gap-3 overflow-x-auto">
                    <template x-for="item in cart" :key="item.menu_id">
                        <div class="text-sm bg-gray-100 px-2 py-1 rounded">
                            <span x-text="item.name"></span> (<span x-text="item.quantity"></span>)
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <p class="text-lg font-semibold text-gray-800">
                    Total: Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span>
                </p>

                <a href="{{ route('landing.checkout') }}" 
                    @click.prevent="saveCartBeforeCheckout"
                    class="flex-shrink-0 px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-primary hover:bg-brand-primary/90 transition">
                    Checkout
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Roemah Kuliner. All rights reserved.</p>
        </div>
    </footer>

    <script>
    function menuApp() {
        return {
            cart: [],

            init() {
                const saved = localStorage.getItem('cart');
                if (saved) this.cart = JSON.parse(saved);
                this.$watch('cart', (value) => {
                    localStorage.setItem('cart', JSON.stringify(value));
                });
            },

            addToCart(menu) {
                const existing = this.cart.find(item => item.menu_id === menu.menu_id);
                if (existing) existing.quantity++;
                else this.cart.push({ menu_id: menu.menu_id, name: menu.name, price: menu.price, quantity: 1 });
            },

            updateQuantity(id, change) {
                const item = this.cart.find(i => i.menu_id === id);
                if (item) {
                    item.quantity += change;
                    if (item.quantity <= 0) this.cart = this.cart.filter(i => i.menu_id !== id);
                }
            },

            getCartItem(id) {
                return this.cart.find(i => i.menu_id === id);
            },

            get totalItems() {
                return this.cart.reduce((sum, i) => sum + i.quantity, 0);
            },

            get totalPrice() {
                return this.cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
            },

            saveCartBeforeCheckout() {
                fetch('{{ route('landing.saveCartSession') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.cart)
                }).then(() => {
                    window.location.href = '{{ route('landing.checkout') }}';
                });
            }
        }
    }
    </script>
    <script> localStorage.removeItem('cart'); </script>
</body>
</html>
