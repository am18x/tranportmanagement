<?php
include 'db_connection.php';

$id = $_POST['id'];

// Start transaction
$conn->begin_transaction();

try {
    // Check if the vehicle is referenced in the driver table
    $sql = "SELECT id FROM driver WHERE vehical_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        // If the vehicle is referenced, set vehical_id to NULL in the driver table
        $sql = "UPDATE driver SET vehical_id = NULL WHERE vehical_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } 
        
        $sql = "DELETE FROM vehical WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

    // Commit transaction
    $conn->commit();

    echo 'Vehicle details are updated successfully';
} catch (Exception $e) {
    // Rollback transaction if there is an error
    $conn->rollback();

    echo 'Error updating vehicle details: ' . $e->getMessage();
}

$conn->close();
?>