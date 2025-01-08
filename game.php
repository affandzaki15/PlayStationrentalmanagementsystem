<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION['user_name']; // Nama pengguna dari session
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayStation Games</title>
    <link rel="stylesheet" href="styleg.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <span>PlayStation Games</span>
        </div>
        <div class="user-info">
            <span>Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </header>
    
    <main>
        <h1>PLAYSTATION GAMES</h1>
        <div class="game-grid">
            <!-- Game Items -->
            <div class="game-item">
                <img src="images/44fe2462-61df-4d1f-9a0f-c700e4f6fb33.jpg" alt="Game 1">
                <p>E-FOOTBALL 2025</p>
            </div>
            <div class="game-item">
                <img src="images/72a965c6-792d-4dbc-a33a-0f26b72e1e14.jpg" alt="Game 2">
                <p>FIFA 2022</p>
            </div>
            <div class="game-item">
                <img src="images/6d6de2ef-3f6f-4d4e-8fd1-47ce24126d53.jpg" alt="Game 3">
                <p>PES GEMBOX 25</p>
            </div>
            <div class="game-item">
                <img src="images/2860018_e90ccbca-abc9-43fe-a79f-cde19d08e915_1499_1499.jpeg" alt="Game 4">
                <p>CALL OF DUTY</p>
            </div>
            <div class="game-item">
                <img src="images/Need_for_Speed_2015.jpg" alt="Game 5">
                <p>NEED FOR SPEED</p>
            </div>
            <div class="game-item">
                <img src="images/613lyxBIXoL._AC_UF894,1000_QL80_.jpg" alt="Game 6">
                <p>GOD OF WAR</p>
            </div>
            <!-- Tambahan 6 Item -->
           
            <div class="game-item">
                <img src="images/playstation_ps5_game_-_nba_2k25_asia_ver_all-star_edition__240725041518_1.jpg" alt="Game 9">
                <p>NBA 2K25</p>
            </div>
            <div class="game-item">
                <img src="images/images.jpeg" alt="Game 10">
                <p>FINAL FANTASY</p>
            </div>
            <div class="game-item">
                <img src="images/af672aad2df32b4a377ff64f1fc322361eeac49e_625380.jpg" alt="Game 11">
                <p>FORTNITE</p>
            </div>
            <div class="game-item">
                <img src="images/sony_s_4_grand_theft_auto_v_-_gta_5_ps_4_original_baru__full03_gwdlhkzr.jpg" alt="Game 12">
                <p>GTA V</p>
            </div>
        </div>
        <!-- Tombol Kembali -->
        <div class="button-container">
            <a href="fasilitas.php" class="back-button">Kembali</a>
        </div>
    </main>
</body>
</html>
