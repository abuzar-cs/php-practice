<?php
session_start();
require_once "conn.php"; // Ensure this file contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    // Check if username and password exist in database
    $stmt = $conn->prepare("SELECT * FROM empdata WHERE name = ? AND password = ?");
    $stmt->bind_param("ss", $name, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION["name"] = $name; // Store username in session variable

        // Redirect to a page or dashboard
        header("Location: index.php"); // Redirect to success.php or any other success page
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }

    $stmt->close();
}
?>
