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

// Retrieve the last order from the database
$sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1"; // Replace 'id' with the correct column name
$result = $conn->query($sql);

// Check if the query executed successfully
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate receipt HTML with styling and animation
        $receiptHTML = "
        <style>
            .receipt-container {
                font-family: Arial, sans-serif;
                border: 1px solid #ccc;
                padding: 20px;
                margin: 20px;
                border-radius: 10px;
                background-color: #f9f9f9;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .receipt-header {
                text-align: center;
                margin-bottom: 20px;
            }
            .billing-details, .shipping-details {
                margin-bottom: 20px;
            }
            .payment-success {
                animation: paymentSuccess 2s infinite;
                text-align: center;
                color: green;
                font-size: 24px;
            }
            .action-buttons {
                text-align: center;
                margin-top: 20px;
            }
            .action-buttons button {
                padding: 10px 20px;
                margin-right: 10px;
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                transition-duration: 0.4s;
                cursor: pointer;
                border-radius: 8px;
            }

            .action-buttons button:hover {
                background-color: #45a049;
            }

            @keyframes paymentSuccess {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
        </style>
        <div class='receipt-container'>
            <div class='receipt-header'>
                <h1>Receipt</h1>
            </div>
            <div class='billing-details'>
                <h2>Billing Details</h2>
                <p><strong>Name:</strong> " . $row['billing_name'] . "</p>
                <p><strong>Email:</strong> " . $row['billing_email'] . "</p>
                <p><strong>City:</strong> " . $row['billing_city'] . "</p>
                <p><strong>Address:</strong> " . $row['billing_address'] . "</p>
                <p><strong>ZIP Code:</strong> " . $row['billing_zip'] . "</p>
                <p><strong>Country:</strong> " . $row['billing_country'] . "</p>
            </div>
            <div class='shipping-details'>
                <h2>Shipping Details</h2>
                <p><strong>Name:</strong> " . $row['shipping_name'] . "</p>
                <p><strong>Email:</strong> " . $row['shipping_email'] . "</p>
                <p><strong>City:</strong> " . $row['shipping_city'] . "</p>
                <p><strong>Address:</strong> " . $row['shipping_address'] . "</p>
                <p><strong>ZIP Code:</strong> " . $row['shipping_zip'] . "</p>
                <p><strong>Country:</strong> " . $row['shipping_country'] . "</p>
            </div>
            <div class='payment-success'>
                Payment Successful! Thank you for your purchase.
            </div>
            <div class='action-buttons'>
                <button onclick='window.print()'>Print Receipt</button>
            </div>
        </div>
        ";

        // Output the receipt HTML
        echo $receiptHTML;
    } else {
        echo "No orders found";
    }
}

$conn->close();
?>
