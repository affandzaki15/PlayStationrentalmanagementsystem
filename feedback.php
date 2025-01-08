<?php
session_start();
include 'database.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$alertMessage = "";

// Ambil nama user dari tabel user
$sqlUser = "SELECT name FROM user WHERE user_id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userName = $resultUser->fetch_assoc()['name'];

// Proses saat form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Simpan feedback ke tabel feedback
    $sqlInsert = "INSERT INTO feedback (user_id, comments, rating) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("isi", $userId, $comment, $rating);

    if ($stmtInsert->execute()) {
        $alertMessage = "Terima kasih atas komentar dan rating Anda!";
    } else {
        $alertMessage = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }
        .form-group textarea {
            resize: none;
            height: 100px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #e98635;
            border: none;
            border-radius: 5px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #fff;
        }
        .alert {
            padding: 10px;
            background-color: #e98635;
            color: #000;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .back-button {
            display: block;
            margin: 20px auto 0;
            text-align: center;
            color: #e98635;
            text-decoration: none;
            font-weight: bold;
        }
        .back-button:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Alert Message -->
        <?php if ($alertMessage): ?>
            <div class="alert"><?php echo htmlspecialchars($alertMessage); ?></div>
        <?php endif; ?>

        <h1>Feedback</h1>
        <form method="POST">
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" value="<?php echo htmlspecialchars($userName); ?>" readonly>
            </div>

            <!-- Komentar -->
            <div class="form-group">
                <label for="comment">Komentar:</label>
                <textarea name="comment" id="comment" required></textarea>
            </div>

            <!-- Rating -->
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit">Submit</button>
        </form>

        <!-- Tombol Kembali -->
        <a href="fasilitas.php" class="back-button">Kembali</a>
    </div>
</body>
</html>
