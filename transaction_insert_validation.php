<?php

    include 'db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $transId = $_POST['transId'];
        $billId = $_POST['billId'];
        $amount = $_POST['amount'];
        $paymentMethod = $_POST['paymentMethod'];
        $receiver = $_POST['receiver'];
        $date = $_POST['date'];

        // Check if all fields are filled
        if(empty($transId) || empty($billId) || empty($amount) || empty($paymentMethod) || empty($receiver) || empty($date)){
            echo "All fields are required";
            exit;
        }

        // Check if amount is a number
        if (!is_numeric($amount)) {
            echo "Amount must be a numeric value";
            exit;
        }

        // If all checks pass, insert the data into the database
        $sql = "INSERT INTO transaction (id, bill_id, amount, payment_method, receiver, date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissss", $transId, $billId, $amount, $paymentMethod, $receiver, $date);
        
        if($stmt->execute()) {
            echo "<script>window.top.location='transaction_history.php'; alert('Transaction Details Saved Successfully');</script>";
        } else {
            echo "There was an error while inserting the data into the database";
        }
    }
?>