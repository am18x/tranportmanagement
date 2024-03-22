<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_paymentId'])) {
        $paymentId = $_POST['edit_paymentId'];
        $driverId = $_POST['edit_driverId'];
        $salary = $_POST['edit_salary'];
        $amountPayed = $_POST['edit_amountPayed'];
        $remaining = $_POST['edit_remaining'];
        $payerId = $_POST['edit_payerId'];
        $date = $_POST['edit_date'];

        // Prepare a SQL UPDATE query to update the payment with the given id
        $sql = "UPDATE driver_payment SET salary = ?, amount_payed = ?, remaining = ?, payer_id = ?, date = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddiisi", $salary, $amountPayed, $remaining, $payerId, $date, $paymentId);
        $stmt->execute();

        echo "<script>window.top.location='driver_payment_history.php'; alert('Payment Details Updated Successfully');</script>";
    } else {
        echo "No payment id parameter provided";
    }
}
?>