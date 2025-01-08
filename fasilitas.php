<?php
session_start();

// Redirect ke login jika session belum ada
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

// Ambil nama pengguna dari session
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Dzaaks Game Center</title>
    <link rel="stylesheet" href="stylef.css">
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="images/WhatsApp Image 2024-12-25 at 20.42.03_b3e6e843.jpg" alt="Logo Dzaaks">
            <span>Dzaaks Game Center</span>
        </div>
        <nav class="menu">
            <a href="fasilitas.php">Fasilitas</a>
            <a href="booking.php">Booking</a>
            <a href="game.php">Games</a>
            <a href="feedback.php">Feedback</a>
        </nav>
        <div class="user-info">
            <img src="images/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg" alt="User Icon">
            <span><?php echo htmlspecialchars($userName); ?></span>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>

    <!-- Konten Fasilitas -->
    <main id="fasilitas" class="main-content">
        <h1>Fasilitas</h1>
        <p>Selamat datang di Dzaaks Game Center! Temukan berbagai fasilitas terbaik untuk pengalaman bermain yang seru dan menyenangkan.</p>
    </main>
        <!-- 6 Foto Fasilitas -->
        <div class="foto-grid">
            <div class="foto-item">
                <img src="images/download (3).jpeg" alt="Foto 1">
                <p>HARGA MULAI DARI 10.000</p>
            </div>
            <div class="foto-item">
                <img src="images/Black Friday_ Will there be any PS5 deals_.jpeg" alt="Foto 2">
                <p>FULL GAME TERBARU</p>
            </div>
            <div class="foto-item">
                <img src="images/download (2).jpeg" alt="Foto 3">
                <p>SNACK & MINUMAN</p>
            </div>
            <div class="foto-item">
                <img src="images/🫡.jpeg" alt="Foto 4">
                <p>TV 32 ~ 50 INCH</p>
            </div>
            <div class="foto-item">
                <img src="images/download (1).jpeg" alt="Foto 5">
                <p>FREE WIFI</p>
            </div>
            <div class="foto-item">
                <img src="images/Neon Effects PNG Image, Neon Effect Of Snowflakes, Blue Snowflakes, Symmetrical Snowflakes, Neon Light Effect Of Snowflakes PNG Image For Free Download.jpeg" alt="Foto 6">
                <p>FULL AC</p>
            </div>
        </div>
    

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="kontak">
                <img src="images/support-custom.png" alt="Phone Icon">
                <span>0851-5679-8811 (Admin - Dzanas)</span>
            </div>
        </div>
    </footer>
</body>
</html>
