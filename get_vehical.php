<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT * FROM vehical WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the vehicle details filled in
    $form = '
    <form id="editVehical" action="edit_vehical.php" method="post" enctype="multipart/form-data">
        <label for="error" class="error" role="alert" id="error"></label>
        <div class="form-group">
            <label for="edit_vehicalId">Vehicle ID</label>
            <input type="text" class="form-control" id="edit_vehicalId" name="edit_vehicalId" value="'.$row['id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_vehicalName">Vehicle Name</label>
            <input type="text" class="form-control" id="edit_vehicalName" name="edit_vehicalName" value="'.$row['vehical_name'].'">
        </div>
        <div class="form-group">
            <label for="edit_vehicalNum">Vehicle Number</label>
            <input type="text" class="form-control" id="edit_vehicalNum" name="edit_vehicalNum" value="'.$row['vehical_number'].'">
        </div>
        <div class="form-group">
            <label for="edit_ownerId">Owner ID</label>
            <input type="text" class="form-control" id="edit_ownerId" name="edit_ownerId" value="'.$row['owner_id'].'">
        </div>
        <div class="form-group">
            <label for="edit_registration">Registration Document</label>
            <input type="file" class="form-control" id="edit_registration" name="edit_registration" accept=".pdf">
        </div>
        <div class="form-group">
            <label for="edit_insurance">Insurance Document</label>
            <input type="file" class="form-control" id="edit_insurance" name="edit_insurance" accept=".pdf">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No vehicle found with the given id';
}
?>