<?php
// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a parameter for the order ID
$order_id = $_GET['order_id']; // This should be sanitized or validated in a real application

// SQL query to fetch order items for the given order ID
$sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $order_items = array();

    // Fetching and formatting results
    while($row = $result->fetch_assoc()) {
        $order_items[] = array(
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'amount' => $row['amount']
        );
    }

    // JSON encode the order items array
    echo json_encode($order_items);
} else {
    echo "No order items found";
}

$conn->close();
?>
