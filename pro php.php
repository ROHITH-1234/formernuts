<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $sname = $_POST['sname'];
    $semail = $_POST['semail'];
    $scity = $_POST['scity'];
    $saddress = $_POST['saddress'];
    $szip = $_POST['szip'];
    $scountry = $_POST['scountry'];

    // Prepare an insert statement
    $sql = "INSERT INTO orders (name, email, city, address, zip, country, sname, semail, scity, saddress, szip, scountry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssssssss", $name, $email, $city, $address, $zip, $country, $sname, $semail, $scity, $saddress, $szip, $scountry);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to order confirmation page
            header("Location: order.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
