<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data nama pengguna dari session
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "User";

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .logo img {
            width: 50px;
            height: 50px;
        }
        .logo span {
            font-size: 1.5rem;
            font-weight: bold;
            margin-left: 10px;
        }
        .alert {
            display: inline-block;
            background-color: #FFD700;
            color: #000;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #ccc;
        }
        .back-button {
            padding: 10px 20px;
            background-color: #444;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #e98635;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="images/WhatsApp Image 2024-12-25 at 20.42.03_b3e6e843.jpg" alt="Logo">
            <span>Dzaaks Game Center</span>
        </div>

        <!-- Alert -->
        <div class="alert">Menunggu Persetujuan Admin</div>

        <!-- Description -->
        <div class="description">
            Halo, <?php echo htmlspecialchars($userName); ?>! <br>
            Admin Dzaaks akan meninjau pembayaran Anda dan melakukan verifikasi. <br>
            Proses ini biasanya memerlukan waktu 3-5 menit. <br>
            Harap cek notifikasi Anda pada menu booking - cek invoice untuk update status pembayaran.
        </div>

        <!-- Back Button -->
        <button class="back-button" onclick="window.location.href='fasilitas.php';">Kembali</button>
    </div>
</body>
</html>
