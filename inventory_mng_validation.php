<?php

    include 'db_connection.php';

    // Rest of your code...

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productId = $_POST['productId'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $totalValue = $_POST['totalValue'];

        // Check if all fields are filled
        if(empty($productId) || empty($productName) || empty($price) || empty($quantity) || empty($totalValue)){
            echo "All fields are required";
            exit;
        }

        // Check if product name contains only alphabets
        if (!preg_match("/^[a-zA-Z ]*$/",$productName)) {
            echo "Only letters and white space allowed in product name";
            exit;
        }

        // Check if price, quantity and total value are numeric
        if (!is_numeric($price) || !is_numeric($quantity) || !is_numeric($totalValue)) {
            echo "Price, quantity and total value must be numeric values";
            exit;
        }

        // If all checks pass, insert the data into the database
        $sql = "INSERT INTO inventory (product_id, product_name, price, quantity, total_value) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $productId, $productName, $price, $quantity, $totalValue);
        
        if($stmt->execute()) {
            echo "<script>window.top.location='inventory_management.php'; alert('Inventory Details Saved Successfully');</script>";
        } else {
            echo "There was an error while inserting the data into the database";
        }
    }
?>