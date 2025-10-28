<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Lezat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">🍽️ Restoran Lezat</div>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="{{ route('landingpage.menu') }}">Menu</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di <span>Restoran Lezat</span></h1>
            <p>Temukan cita rasa terbaik dari bahan pilihan dan chef profesional kami.</p>
            <a href="{{ route('landingpage.menu') }}" class="btn-primary">🍜 Pesan Sekarang</a>
        </div>
    </section>

    <footer>
        <p>© <?= date('Y') ?> Restoran Lezat. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
@vite('resources/css/style.css')
