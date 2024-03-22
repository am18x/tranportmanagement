<?php
include 'db_connection.php';

$id = $_POST['id'];

try {
    // Get the details of the transaction
    $sql = "SELECT bill_id, amount FROM transaction WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bill_id = $row['bill_id'];
    $amount = $row['amount'];
    $stmt->close();

    // Delete the record in the transaction table
    $sql = "DELETE FROM transaction WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo 'Transaction deleted successfully';
} catch (Exception $e) {
    echo 'Error deleting transaction: ' . $e->getMessage();
}

$conn->close();
?>