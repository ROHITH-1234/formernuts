<?php
// Database configuration
$servername = "localhost";  // Replace with your server name
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "shop";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the cart data
    $cartData = json_decode($_POST['cart'], true);

    // Retrieve billing details
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $city = $conn->real_escape_string($_POST['city']);
    $address = $conn->real_escape_string($_POST['address']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $country = $conn->real_escape_string($_POST['country']);

    // Retrieve shipping details
    $sname = $conn->real_escape_string($_POST['sname']);
    $semail = $conn->real_escape_string($_POST['semail']);
    $scity = $conn->real_escape_string($_POST['scity']);
    $saddress = $conn->real_escape_string($_POST['saddress']);
    $szip = $conn->real_escape_string($_POST['szip']);
    $scountry = $conn->real_escape_string($_POST['scountry']);

    // Insert the order into the orders table
    $sql = "INSERT INTO orders (billing_name, billing_email, billing_city, billing_address, billing_zip, billing_country, shipping_name, shipping_email, shipping_city, shipping_address, shipping_zip, shipping_country) VALUES ('$name', '$email', '$city', '$address', '$zip', '$country', '$sname', '$semail', '$scity', '$saddress', '$szip', '$scountry')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted order ID
        $orderID = $conn->insert_id;

        // Insert each cart item into the order_items table
        foreach ($cartData as $item) {
            $itemName = $conn->real_escape_string($item['item']);
            $itemQty = (int)$item['qty'];
            $itemPrice = (float)$item['price'];
            
            $sqlItem = "INSERT INTO order_items (order_id, item_name, item_qty, item_price) VALUES ($orderID, '$itemName', $itemQty, $itemPrice)";
            $conn->query($sqlItem);
        }

        // Redirect to submitorder.html
        header("Location: save_payment.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>