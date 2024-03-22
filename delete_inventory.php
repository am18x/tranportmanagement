<?php
include 'db_connection.php';

$id = $_POST['id'];

try {
    // Get the name of the inventory item
    $sql = "SELECT product_name FROM inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $item_name = $row['product_name'];
    $stmt->close();

    // Delete the record in the inventory table
    $sql = "DELETE FROM inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo 'Inventory item deleted successfully';
} catch (Exception $e) {
    echo 'Error deleting inventory item: ' . $e->getMessage();
}

$conn->close();
?>