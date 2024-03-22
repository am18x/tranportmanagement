<?php

    include 'db_connection.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $driverId = $_POST['driverId'];
        $driverName = $_POST['driverName'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $salary = $_POST['salary'];
        $advanceAmount = $_POST['advanceAmount'];
        $license = $_FILES['license']['name'];
        $vehical_id = $_POST['vehical_id'];
        $password = $_POST['password'];

        // Check if all fields are filled
        if(empty($driverId) || empty($driverName) || empty($username) || empty($email) || empty($address) || empty($phone) || empty($salary) || empty($advanceAmount) || empty($license) || empty($vehical_id) || empty($password)){
            echo "All fields are required";
            exit;
        }

        // Check if driver name contains only alphabets
        if (!preg_match("/^[a-zA-Z ]*$/",$driverName)) {
            echo "Only letters and white space allowed in driver name";
            exit;
        }

        // Check if username already exists
        $sql = "SELECT * FROM driver WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            echo "Username already exists";
            exit;
        }

        // Check if phone number is valid
        if (!preg_match("/^[0-9]{10}$/",$phone)) {
            echo "Invalid phone number";
            exit;
        }

        // Check if salary and advance amount are integers
        if (!is_numeric($salary) || !is_numeric($advanceAmount) || floor($salary) != $salary || floor($advanceAmount) != $advanceAmount) {
            echo "Salary and advance amount must be integer values";
            exit;
        }

        //rename the pdf file as username
        $license = $username . ".pdf";

        //copy the file into uploads folder in current directory
        $target_dir = "uploads/";
        $target_file = $target_dir . $license; // Use the renamed filename

        if (move_uploaded_file($_FILES["license"]["tmp_name"], $target_file)) {
            echo "The file ". $license. " has been uploaded."; // Use the renamed filename
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
        // If all checks pass, insert the data into the database
        $sql = "INSERT INTO driver (username, fullname, email, address, phone_no, salary, license, vehical_id, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisss", $username, $driverName, $email, $address, $phone, $salary, $license, $vehical_id, $password);
        
        if($stmt->execute()) {
            // Get the id of the last inserted record
            $driverId = $conn->insert_id;

            //open the driver_management.php page outside the modal
            $date = date('Y-m-d');
            $sql = "INSERT INTO driver_payment (driver_id, advance, date) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $driverId, $advanceAmount, $date);
            if ($stmt->execute()) {
                echo "<script>window.top.location='driver_management.php'; alert('Driver Details Saved Successfully');</script>";
            }
            else {
                echo "There was an error while inserting the data into the database";
            }
        } else {
            echo "There was an error while inserting the data into the database";
        }

        

    }
?>