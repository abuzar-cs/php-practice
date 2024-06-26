<?php
require_once "conn.php"; // Ensure this file contains your database connection
echo "login successfull";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phno = $_POST["phno"];
    $address = $_POST["address"];
    $designation = $_POST["designation"];
    $password = $_POST["password"];

    // SQL Injection prevention: Use prepared statements
    $stmt = $conn->prepare("INSERT INTO empdata (name, phno, address, designation, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phno, $address, $designation, $password);

    if ($stmt->execute()) {
        echo "Data inserted to database successfully.<br>";
    } else {
        echo "Insertion failed.<br>";
    }

    // File Upload handling
    $target_dir = "empimgs/"; // Make sure this directory exists and has proper permissions
    $target_file = $target_dir . basename($_FILES["empimg"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["empimg"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["empimg"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["empimg"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["empimg"]["name"])) . " has been uploaded.<br>";
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>
