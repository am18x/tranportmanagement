<?php
include 'db_connection.php';

$billId = $_POST['id'];
$driver_id = $_POST['driver_id'];

// Start transaction
$conn->begin_transaction();

try {
    // Delete the record in the bills table
    $sql = "DELETE FROM bills WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $billId);
    $stmt->execute();

    // Delete the record in the trips table
    $sql = "DELETE FROM trips WHERE driver_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driver_id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    echo 'Bill and trip details are deleted successfully';
} catch (Exception $e) {
    // Rollback transaction if there is an error
    $conn->rollback();

    echo 'Error deleting bill and trip: ' . $e->getMessage();
}

$stmt->close();
$conn->close();
?>