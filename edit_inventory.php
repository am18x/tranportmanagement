<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_productId'])) {
        $id = $_POST['edit_productId'];
        $item_name = $_POST['edit_productName'];
        $price = $_POST['editPrice'];
        $quantity = $_POST['editQuantity'];
        $totalValue = $_POST['editTotalValue'];

        // Prepare a SQL UPDATE query to update the inventory item with the given id
        $sql = "UPDATE inventory SET product_name = ?, price = ?, quantity = ?, total_value = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $item_name, $price, $quantity, $totalValue, $id);
        $stmt->execute();

        echo "<script>window.top.location='inventory_management.php'; alert('Inventory Details Updated Successfully');</script>";
    } else {
        echo "No id parameter provided";
    }
}
?>