<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials
    $sql = "SELECT user_id, name, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: fasilitas.php"); // Redirect after successful login
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    } else {
        $error = "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Left side image -->
        <div class="image-section">
            <img src="images/WhatsApp Image 2024-12-25 at 20.42.03_b3e6e843.jpg" alt="PlayStation Rental" />
        </div>

        <!-- Right side login form -->
        <div class="form-section">
            <div class="form-container">
                <h2>Login</h2>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                <form method="POST">
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <p>Forgot your password? <a href="forgot-password.php">Reset here</a></p>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
