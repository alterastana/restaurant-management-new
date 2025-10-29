<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="navbar bg-brand-primary text-white">
        <div class="logo">{{ config('app.name') }}</div>
        <nav>
            <a href="{{ route('landingpage.index') }}">Home</a>
            <a href="{{ route('landingpage.menu') }}">Menu</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content animate-fade-in">
            <h1>Welcome to <span class="brand-accent">{{ config('app.name') }}</span></h1>
            <p>Discover the best flavors made from quality ingredients by our professional chefs.</p>
            <a href="{{ route('landingpage.menu') }}" class="btn-primary">🍜 Order Now</a>
        </div>
    </section>

    <footer class="bg-brand-primary text-white py-4 text-center mt-12">
    <p>© <?= date('Y') ?> {{ config('app.name') }}. All rights reserved.</p>
    </footer>
</body>
</html>
