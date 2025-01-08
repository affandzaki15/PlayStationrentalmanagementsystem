<?php
session_start();
include 'database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil data pengguna dari tabel user
$sqlUser = "SELECT name FROM user WHERE user_id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userName = $resultUser->fetch_assoc()['name'];

// Ambil data booking terakhir berdasarkan user_id
$sqlBooking = "SELECT * FROM booking WHERE user_id = ? ORDER BY booking_id DESC LIMIT 1";
$stmtBooking = $conn->prepare($sqlBooking);
$stmtBooking->bind_param("i", $userId);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();
$booking = $resultBooking->fetch_assoc();

if (!$booking) {
    echo "<script>alert('Tidak ada invoice ditemukan.'); window.location.href = 'booking.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .detail {
            margin-bottom: 20px;
        }
        .detail p {
            margin: 5px 0;
        }
        .rekening {
            margin-top: 20px;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .rekening ul {
            padding-left: 20px;
        }
        .status {
            font-weight: bold;
            color: #e98635;
        }
        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
        .btn-back {
            padding: 10px 20px;
            background-color: #e98635;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Invoice</h1>
        <div class="detail">
            <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($userName); ?></p>
            <p><strong>Nomor Tempat:</strong> <?php echo htmlspecialchars($booking['nomor_tempat']); ?></p>
            <p><strong>Hari/Tanggal:</strong> <?php echo htmlspecialchars($booking['hari'] . ', ' . $booking['tanggal']); ?></p>
            <p><strong>Jam Mulai:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($booking['start_time']))); ?></p>
            <p><strong>Jam Akhir:</strong> <?php echo htmlspecialchars(date('H:i', strtotime($booking['end_time']))); ?></p>
            <p><strong>Total Pembayaran:</strong> Rp<?php echo number_format($booking['amount_paid'], 0, ',', '.'); ?></p>
            <p><strong>Status Pembayaran:</strong> <span class="status"><?php echo htmlspecialchars($booking['payment_status']); ?></span></p>
        </div>
        <div>
            <p>Notes : Tunjukkan Invoice ini ke penjaga rental</p>
            <p>Selamat Bermain and Enjoy the Game</p>
        </div>

  

        <div class="btn-container">
            <a href="fasilitas.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>
