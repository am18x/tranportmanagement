<?php
include 'db_connection.php';

$paymentId = $_POST['id'];

// Start transaction
$conn->begin_transaction();

try {
    // Delete the record in the driver_payment_history table
    $sql = "DELETE FROM driver_payment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentId);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();

    echo 'Payment details are deleted successfully';
} catch (Exception $e) {
    // Rollback transaction if there is an error
    $conn->rollback();

    echo 'Error deleting payment: ' . $e->getMessage();
}

$conn->close();
?>