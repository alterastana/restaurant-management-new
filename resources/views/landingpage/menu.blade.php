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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Restoran Lezat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">🍽️ Restoran Lezat</div>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="menu.php" class="active">Menu</a>
        </nav>
    </header>

    <section class="menu-section">
        <h2>Daftar Menu Kami</h2>
        <div class="menu-grid">
            <?php foreach ($menus as $makanan): ?>
                <div class="menu-card">
                    <img src="<?= $makanan['gambar'] ?>" alt="<?= $makanan['nama'] ?>">
                    <h3><?= $makanan['nama'] ?></h3>
                    <p>Rp <?= number_format($makanan['harga'], 0, ',', '.') ?></p>
                    <button class="btn-secondary">Pesan</button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <p>© <?= date('Y') ?> Restoran Lezat. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
@vite('resources/css/style.css')
