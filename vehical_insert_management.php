<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicalId = $_POST['vehicalId'];
    $ownerId = $_POST['ownerId'];
    $vehicalName = $_POST['vehicalName'];
    $vehicalNum = $_POST['vehicalNum'];
    $registration = $_FILES['registration']['name'];
    $insurance = $_FILES['insurance']['name'];

    // Check if all fields are filled
    if(empty($vehicalId) || empty($ownerId) || empty($vehicalName) || empty($vehicalNum) || empty($registration) || empty($insurance)){
        echo "All fields are required";
        exit;
    }

    // Rename the registration and insurance files as vehicalId
    $registration = $vehicalNum . "_registration.pdf";
    $insurance = $vehicalNum . "_insurance.pdf";

    // Copy the files into uploads folder in current directory
    $target_dir = "uploads/vehical/";
    $target_file_registration = $target_dir . $registration;
    $target_file_insurance = $target_dir . $insurance;

    if (move_uploaded_file($_FILES["registration"]["tmp_name"], $target_file_registration) && move_uploaded_file($_FILES["insurance"]["tmp_name"], $target_file_insurance)) {
        echo "The files have been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your files.";
        exit;
    }

    // If all checks pass, insert the data into the database
    $sql = "INSERT INTO vehical (id, owner_id, vehical_number, vehical_name, registration, insurance) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $vehicalId, $ownerId, $vehicalNum, $vehicalName, $registration, $insurance);
    
    if($stmt->execute()) {
        echo "<script>window.top.location='vehical_management.php'; alert('Vehicle Details Saved Successfully');</script>";
    } else {
        echo "There was an error while inserting the data into the database";
    }
}
?>