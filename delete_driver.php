<?php
include 'db_connection.php';

$id = $_POST['id'];

// Start transaction
$conn->begin_transaction();

try {
    // Get the username of the driver
    $sql = "SELECT username FROM driver WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $stmt->close();

    // Delete the records in the driver_payment table
    $sql = "DELETE FROM driver_payment WHERE driver_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Delete the record in the driver table
    $sql = "DELETE FROM driver WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Delete the file
    $file = 'uploads/' . $username . '.pdf';
    if (file_exists($file)) {
        if (unlink($file)) {
            echo 'File deleted successfully';
        } else {
            echo 'Error deleting file';
        }
    } else {
        echo 'File does not exist';
        exit();
    }

    echo 'Driver details and file are deleted successfully';
} catch (Exception $e) {
    // Rollback transaction if there is an error
    $conn->rollback();

    echo 'Error deleting driver: ' . $e->getMessage();
}

$conn->close();
?>