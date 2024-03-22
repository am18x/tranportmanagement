<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_transId'])) {
        $transactionId = $_POST['edit_transId'];
        $billId = $_POST['edit_billId'];
        $amount = $_POST['edit_amount'];
        $paymentMethod = $_POST['edit_paymentMethod'];
        $receiver = $_POST['edit_receiver'];
        $date = $_POST['edit_date'];

        // Start transaction
        $conn->begin_transaction();

        try {
            // Prepare a SQL UPDATE query to update the payment with the given id
            $sql = "UPDATE transaction SET bill_id = ?, amount = ?, payment_method = ?, receiver = ?, date = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("idsssi", $billId, $amount, $paymentMethod, $receiver, $date, $transactionId);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            echo "<script>window.top.location='transaction_history.php'; alert('Transaction Details Updated Successfully');</script>";
        } catch (Exception $e) {
            // Rollback transaction if there is an error
            $conn->rollback();

            echo 'Error updating transaction: ' . $e->getMessage();
        }
    } else {
        echo "No transaction id parameter provided";
    }
}
?>