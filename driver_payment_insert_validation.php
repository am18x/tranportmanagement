<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentId = $_POST['paymentId'];
    $driverId = $_POST['driverId'];
    $salary = $_POST['salary'];
    $amountPayed = $_POST['amountPayed'];
    $remaining = $_POST['remaining'];
    $payerId = $_POST['payerId'];
    $date = $_POST['date'];

    // Check if all fields are filled
    if(empty($paymentId) || empty($driverId) || empty($salary) || empty($amountPayed) || empty($remaining) || empty($payerId) || empty($date)){
        echo "All fields are required";
        exit;
    }

    // Check if salary, amount paid, and remaining are numeric
    if (!is_numeric($salary) || !is_numeric($amountPayed) || !is_numeric($remaining)) {
        echo "Salary, amount paid, and remaining must be numeric values";
        exit;
    }

    // If all checks pass, insert the data into the database
    $sql = "INSERT INTO driver_payment (id, driver_id, salary, amount_payed, remaining, payer_id, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiddiis", $paymentId, $driverId, $salary, $amountPayed, $remaining, $payerId, $date);

    if($stmt->execute()) {
        echo "<script>window.top.location='driver_payment_history.php'; alert('Payment Details Saved Successfully');</script>";
    } else {
        echo "There was an error while inserting the data into the database";
    }
}