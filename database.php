<?php
// Database configuration
$servername = "localhost"; // Replace with your database server (usually localhost)
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$database = "rentalps";    // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can add this line to ensure UTF-8 encoding for the connection
$conn->set_charset("utf8");
?>
