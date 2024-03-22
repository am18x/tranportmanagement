<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_driverId'])) {
        $id = $_POST['edit_driverId'];
        $username = $_POST['edit_username'];
        $email = $_POST['edit_email'];
        $phone_no = $_POST['edit_phone'];
        $address = $_POST['edit_address'];
        $salary = $_POST['edit_salary'];
        $advance = $_POST['edit_advanceAmount'];
        $vehical_id = $_POST['edit_vehical_id'];

        
        $license = $username . ".pdf";
        $target_file = "uploads/" . $license;

        // Delete the old license file
        if(file_exists($target_file)) {
            unlink($target_file);
        }

        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($_FILES["edit_license"]["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }

        // Prepare a SQL UPDATE query to update the driver with the given id
        $sql = "UPDATE driver SET email = ?, phone_no = ?, address = ?, salary = ?, vehical_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $email, $phone_no, $address, $salary, $vehical_id, $id);
        $stmt->execute();

        // Prepare a SQL UPDATE query to update the advance in the driver_payment table
        $sql = "UPDATE driver_payment SET advance = ?, date = CURDATE() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $advance, $id);
        $stmt->execute();

        echo "<script>window.top.location='driver_management.php'; alert('Driver Details Updated Successfully');</script>";
    } else {
        echo "No id parameter provided";
    }

}
?>