<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_vehicalId'])) {
        $id = $_POST['edit_vehicalId'];
        $vehical_name = $_POST['edit_vehicalName'];
        $vehical_number = $_POST['edit_vehicalNum'];
        $owner_id = $_POST['edit_ownerId'];

        $registration = $vehical_number . "_registration.pdf";
        $insurance = $vehical_number . "_insurance.pdf";
        $target_file_reg = "uploads/vehical/" . $registration;
        $target_file_ins = "uploads/vehical/" . $insurance;

        // Delete the old registration and insurance files
        if(file_exists($target_file_reg)) {
            unlink($target_file_reg);
        }
        if(file_exists($target_file_ins)) {
            unlink($target_file_ins);
        }

        // Move the uploaded files to the uploads directory
        if (!move_uploaded_file($_FILES["edit_registration"]["tmp_name"], $target_file_reg)) {
            $registration = $vehical_number . "_registration.pdf";
        }
        if (!move_uploaded_file($_FILES["edit_insurance"]["tmp_name"], $target_file_ins)) {
            $insurance = $vehical_number . "_insurance.pdf";
        }

        // Prepare a SQL UPDATE query to update the vehicle with the given id
        $sql = "UPDATE vehical SET vehical_name = ?, vehical_number = ?, owner_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $vehical_name, $vehical_number, $owner_id, $id);
        $stmt->execute();

        echo "<script>window.top.location='vehical_management.php'; alert('Vehicle Details Updated Successfully');</script>";
    } else {
        echo "No id parameter provided";
    }
}
?>