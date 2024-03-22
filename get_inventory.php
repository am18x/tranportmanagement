<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT * FROM inventory WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the inventory details filled in
    $form = '
    <form id="editInventory" action="edit_inventory.php" method="post">
        <div class="form-group">
            <label for="edit_productId">Product ID</label>
            <input type="text" class="form-control" id="edit_productId" name="edit_productId" value="'.$row['product_id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_productName">Product Name</label>
            <input type="text" class="form-control" id="edit_productName" name="edit_productName" value="'.$row['product_name'].'">
        </div>
        <div class="form-group">
            <label for="editPrice">Price</label>
            <input type="number" class="form-control" id="editPrice" name="editPrice" value="'.$row['price'].'" oninput="calculateTotalValue()">
        </div>
        <div class="form-group">
            <label for="editQuantity">Quantity</label>
            <input type="number" class="form-control" id="editQuantity" name="editQuantity" value="'.$row['quantity'].'" oninput="calculateTotalValue()">
        </div>
        <div class="form-group">
            <label for="editTotalValue">Total Value</label>
            <input type="number" class="form-control" id="editTotalValue" value="'.$row['total_value'].'" name="editTotalValue" readonly>
        </div>

        <script>
        function calculateTotalValue() {
            var price = document.getElementById("editPrice").value;
            var quantity = document.getElementById("editQuantity").value;
            var totalValue = price * quantity;
            document.getElementById("editTotalValue").value = totalValue;
        }
        </script>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No product found with the given id';
}
?>