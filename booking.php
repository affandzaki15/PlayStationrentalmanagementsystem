<?php
session_start();
include 'database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Ambil data user dari session
$sqlUser = "SELECT name FROM user WHERE user_id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userName = $resultUser->fetch_assoc()['name'];

// Ambil daftar PS dari tabel playstation
$sqlPS = "SELECT * FROM playstation";
$resultPS = $conn->query($sqlPS);

// Proses saat form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $psId = $_POST['ps_id'];
    $nomorTempat = $_POST['nomor_tempat'];
    $tanggal = $_POST['tanggal'];
    $startTime = $tanggal . ' ' . $_POST['start_time'] . ":00"; // Kombinasi tanggal dan waktu mulai
    $endTime = $tanggal . ' ' . $_POST['end_time'] . ":00";    // Kombinasi tanggal dan waktu selesai

    // Hitung total durasi dalam jam
    $duration = (strtotime($endTime) - strtotime($startTime)) / 3600;

    if ($duration <= 0) {
        echo "<script>alert('Waktu selesai harus lebih besar dari waktu mulai.');</script>";
    } else {
        // Cek apakah waktu yang dipilih sudah dipesan
        $sqlCheck = "SELECT * FROM booking 
                     WHERE ps_id = ? 
                     AND nomor_tempat = ? 
                     AND tanggal = ? 
                     AND (start_time < ? AND end_time > ?)";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("iisss", $psId, $nomorTempat, $tanggal, $endTime, $startTime);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Jika ada data yang bertabrakan
            echo "<script>alert('Waktu yang dipilih sudah dibooking oleh pengguna lain. Silakan pilih waktu yang berbeda.');</script>";
        } else {
            // Jika tidak ada tabrakan, lanjutkan proses booking
            $amountPaid = $duration * 10000; // Hitung total harga (Rp10.000 per jam)
            $paymentStatus = "Pending";

            // Simpan data ke tabel booking
            $sqlInsert = "INSERT INTO booking (user_id, ps_id, nomor_tempat, tanggal, start_time, end_time, amount_paid, payment_status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("iiisssds", $userId, $psId, $nomorTempat, $tanggal, $startTime, $endTime, $amountPaid, $paymentStatus);

            if ($stmt->execute()) {
                echo "<script>alert('Booking berhasil! Total pembayaran: Rp" . number_format($amountPaid, 0, ',', '.') . ".'); window.location.href='pembayaran.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan booking.');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Tempat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: #222;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar .logo {
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .navbar .menu {
            display: flex;
            gap: 4px;
        }
        .navbar .menu a {
            text-decoration: none;
            color: #fff;
            padding: 10px 30px;
            border-radius: 2px;
            transition: background-color 0.3s;
        }
        .navbar .menu a:hover {
            background-color: #e98635;
        }
        .container {
            padding: 100px 20px 20px; /* Offset untuk navbar */
            text-align: center;
        }
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            padding: 10px;
            width: 80%;
            max-width: 400px;
            border: 1px solid #444;
            border-radius: 5px;
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
        }
        button:hover {
            background-color: #fff;
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
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Dzaaks Game Center</div>
        <div class="menu">
            <a href="invoice.php">Cek Invoice</a>
        </div>
    </div>

    <!-- Konten -->
    <div class="container">
        <h1>Booking Tempat</h1>
        <form method="POST">
            <!-- Nama Pengguna -->
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" value="<?php echo htmlspecialchars($userName); ?>" readonly>
            </div>

            <!-- Pilih PS -->
            <div class="form-group">
                <label for="ps_id">Pilih PS:</label>
                <select name="ps_id" id="ps_id" required>
                    <?php while ($rowPS = $resultPS->fetch_assoc()): ?>
                        <option value="<?php echo $rowPS['ps_id']; ?>">
                            <?php echo $rowPS['model'] . " - Nomor Tempat " . $rowPS['nomor_tempat']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Pilih Tanggal -->
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" required>
            </div>

            <!-- Waktu Mulai -->
            <div class="form-group">
                <label for="start_time">Waktu Mulai</label>
                <input type="time" name="start_time" id="start_time" step="3600" required>
            </div>

            <!-- Waktu Selesai -->
            <div class="form-group">
                <label for="end_time">Waktu Selesai</label>
                <input type="time" name="end_time" id="end_time" step="3600" required>
            </div>

            <!-- Nomor Tempat -->
            <div class="form-group">
                <label for="nomor_tempat">Nomor Tempat:</label>
                <input type="number" name="nomor_tempat" id="nomor_tempat" required>
            </div>

            <button type="submit">Booking</button>
        </form>
        <div class="btn-container">
            <a href="fasilitas.php" class="btn-back">Kembali</a>
        </div>
    </div>
</body>
</html>
