<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password for the user with the given email
    $sql = "UPDATE user SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Password successfully updated! <a href='login.php'>Login here</a>";
            } else {
                echo "No account found with that email.";
            }
        } else {
            echo "Error updating password: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Left side image -->
        <div class="image-section">
            <img src="images/WhatsApp Image 2024-12-25 at 20.42.03_b3e6e843.jpg" alt="Forgot Password" />
        </div>

        <!-- Right side forgot password form -->
        <div class="form-section">
            <div class="form-container">
                <h2>Reset Password</h2>
                <form method="POST">
                    <div class="input-group">
                        <label for="email">Enter your email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <button type="submit">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
