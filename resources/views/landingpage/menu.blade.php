<?php
// Dummy data makanan (biasanya diambil dari database)
$menus = [
    ['nama' => 'Nasi Goreng Spesial', 'harga' => 35000, 'gambar' => 'https://source.unsplash.com/400x300/?fried-rice'],
    ['nama' => 'Mie Ayam Jamur', 'harga' => 25000, 'gambar' => 'https://source.unsplash.com/400x300/?noodles'],
    ['nama' => 'Sate Ayam Madura', 'harga' => 30000, 'gambar' => 'https://source.unsplash.com/400x300/?satay'],
    ['nama' => 'Sop Buntut', 'harga' => 45000, 'gambar' => 'https://source.unsplash.com/400x300/?soup'],
    ['nama' => 'Ayam Geprek Keju', 'harga' => 28000, 'gambar' => 'https://source.unsplash.com/400x300/?chicken'],
];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu - Restoran Lezat</title>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <!-- Add Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Add Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="brand-pill">
                <img src="{{ asset('images/logo.png') }}" class="logo">
                <span class="brand-text">Restoran Lezat</span>
            </a>
            
            <div class="nav-links">
                <a href="{{ route('landing.restaurants') }}">Restaurants</a>
                <a href="{{ route('landing.restaurants') }}#menus">Menus</a>
                <a href="{{ route('landingpage.menu') }}#reservations" class="active">Reservations</a>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endguest
            </div>
        </div>
    </nav>

    <!-- Menu Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 text-center animate__animated animate__fadeInDown">Our Menu</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($menus as $index => $makanan): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden animate__animated animate__fadeInUp" style="animation-delay: <?= $index * 0.2 ?>s">
                    <img src="<?= $makanan['gambar'] ?>" alt="<?= $makanan['nama'] ?>" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2"><?= $makanan['nama'] ?></h3>
                        <p class="text-gray-600 mb-4">Rp <?= number_format($makanan['harga'], 0, ',', '.') ?></p>
                        <button class="w-full px-4 py-2 bg-brand-primary text-white rounded-md hover:bg-brand-primary/90 transition transform hover:-translate-y-0.5">
                            Order Now
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Restoran Lezat</h3>
                    <p class="text-gray-400">Empowering restaurants with modern management solutions</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Email: info@restaurant.com</li>
                        <li class="text-gray-400">Phone: (123) 456-7890</li>
                        <li class="text-gray-400">Address: 123 Restaurant St, City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Restoran Lezat. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
