<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "image_upload_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image-upload']) && $_FILES['image-upload']['error'] == 0) {
        $imageName = $_FILES['image-upload']['name'];
        $imageData = file_get_contents($_FILES['image-upload']['tmp_name']);
        
        $stmt = $conn->prepare("INSERT INTO images (name, image) VALUES (?, ?)");
        $stmt->bind_param("sb", $imageName, $imageData);
        $stmt->send_long_data(1, $imageData);
        
        if ($stmt->execute()) {
            echo "Image uploaded successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Failed to upload image.";
    }
}

$conn->close();
?>
