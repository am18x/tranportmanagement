<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT * FROM bills WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the bill details filled in
    $form = '
    <form id="editBill" action="edit_bill.php" method="post">
        <label for="error" class="error" role="alert" id="error"></label>
        <div class="form-group">
            <label for="edit_billId">Bill ID</label>
            <input type="text" class="form-control" id="edit_billId" name="edit_billId" value="'.$row['id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_driverId">Driver ID</label>
            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId" value="'.$row['driver_id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_numOfItems">Number of Items</label>
            <input type="text" class="form-control" id="edit_numOfItems" name="edit_numOfItems" value="'.$row['num_of_items'].'">
        </div>
        <div class="form-group">
            <label for="edit_vehicalNum">Vehicle Number</label>
            <input type="text" class="form-control" id="edit_vehicalNum" name="edit_vehicalNum" value="'.$row['vehical_number'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_source">Source</label>
            <input type="text" class="form-control" id="edit_source" name="edit_source" value="'.$row['source'].'">
        </div>
        <div class="form-group">
            <label for="edit_destination">Destination</label>
            <input type="text" class="form-control" id="edit_destination" name="edit_destination" value="'.$row['destination'].'">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No bill found with the given id';
}
?>