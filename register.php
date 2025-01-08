<?php
$registrationSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $registrationSuccess = true; // Tandai bahwa registrasi berhasil
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="container">
        <!-- Left side image -->
        <div class="image-section">
            <img src="images/WhatsApp Image 2024-12-25 at 20.42.03_b3e6e843.jpg" alt="PlayStation Rental" />
        </div>

        <!-- Right side form -->
        <div class="form-section">
            <div class="form-container">
                <h2>Register</h2>
                <form method="POST">
                    <div class="input-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <p>Do you have an account? <a href="login.php">Login here</a></p>
                <?php if ($registrationSuccess): ?>
                    <!-- Modal Notifikasi -->
                    <div class="modal-overlay">
                        <div class="modal">
                            <p>Pendaftaran berhasil!</p>
                            <button onclick="redirectToLogin()">OK</button>
                        </div>
                    </div>
                    <script>
                        function redirectToLogin() {
                            window.location.href = 'login.php'; // Redirect ke halaman login
                        }
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>