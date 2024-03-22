<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_billId'])) {
        $billId = $_POST['edit_billId'];
        $driver_id = $_POST['edit_driverId'];
        $num_of_items = $_POST['edit_numOfItems'];
        $vehical_num = $_POST['edit_vehicalNum'];
        $source = $_POST['edit_source'];
        $destination = $_POST['edit_destination'];

        // Prepare a SQL UPDATE query to update the bill with the given id
        $sql = "UPDATE bills SET driver_id = ?, num_of_items = ?, vehical_number = ?, source = ?, destination = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssi", $driver_id, $num_of_items, $vehical_num, $source, $destination, $billId);
        $stmt->execute();

        echo "<script>window.top.location='bill_management.php'; alert('Bill Details Updated Successfully');</script>";
    } else {
        echo "No id parameter provided";
    }
}
?>