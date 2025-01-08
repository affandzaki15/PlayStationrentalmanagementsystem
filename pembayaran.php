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

// Ambil data booking terakhir untuk pengguna yang sedang login
$sqlBooking = "SELECT * FROM booking WHERE user_id = ? ORDER BY booking_id DESC LIMIT 1";
$stmtBooking = $conn->prepare($sqlBooking);
$stmtBooking->bind_param("i", $userId);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();
$booking = $resultBooking->fetch_assoc();

if (!$booking) {
    echo "<script>alert('Tidak ada data booking ditemukan.'); window.location.href='booking.php';</script>";
    exit;
}

// Proses unggah file pembayaran
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['payment_screenshot'])) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['payment_screenshot']['name']);
    $targetFile = $uploadDir . $fileName;
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    // Validasi tipe file
    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $targetFile)) {
            // Update tabel booking dengan file pembayaran
            $sqlUpdate = "UPDATE booking SET payment_screenshot = ? WHERE booking_id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("si", $fileName, $booking['booking_id']);
            if ($stmtUpdate->execute()) {
                echo "<script>alert('Pembayaran berhasil diunggah.'); window.location.href='menunggu.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat memperbarui pembayaran.');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah file pembayaran.');</script>";
        }
    } else {
        echo "<script>alert('Tipe file tidak didukung. Hanya JPG, PNG, dan PDF yang diperbolehkan.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
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
        .upload-section {
            margin-top: 20px;
        }
        input[type="file"] {
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            width: 100%;
        }
        button {
            padding: 10px 20px;
            background-color: #e98635;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background-color: #fff;
        }
        .rekening {
            margin-top: 20px;
            font-size: 0.9rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pembayaran</h1>
        <div class="detail">
            <p>Nama Lengkap: <?php echo htmlspecialchars($userName); ?></p>
            <p>Nomor Tempat: <?php echo htmlspecialchars($booking['nomor_tempat']); ?></p>
            <p>Hari/Tanggal: <?php echo htmlspecialchars($booking['hari'] . ', ' . $booking['tanggal']); ?></p>
            <p>Jam Mulai: <?php echo htmlspecialchars(date('H:i', strtotime($booking['start_time']))); ?></p>
            <p>Jam Akhir: <?php echo htmlspecialchars(date('H:i', strtotime($booking['end_time']))); ?></p>
            <p>Total Pembayaran: Rp<?php echo number_format($booking['amount_paid'], 0, ',', '.'); ?></p>
        </div>

        <div class="rekening">
            <p><strong>Nama Rekening:</strong> Dzaaks Game Center</p>
            <p><strong>No. Rekening:</strong></p>
            <ul>
                <li>5251-9847-3614-8625-7 (BRI)</li>
                <li>7648264529 (BNI)</li>
                <li>089438423994 (SHPAY)</li>
            </ul>
        </div>

        <form method="POST" enctype="multipart/form-data" class="upload-section">
            <label for="payment_screenshot">Upload File Pembayaran:</label>
            <input type="file" name="payment_screenshot" id="payment_screenshot" required>
            <button type="submit">Lanjut</button>
        </form>
    </div>
</body>
</html>
