<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driverId = $_POST['driverId'];
    $num_of_items = $_POST['numOfItems'];
    $vehical_num = $_POST['vehicalNum'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $date = date('Y-m-d'); // Current date

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare a SQL INSERT query to insert a new bill
        $sql = "INSERT INTO bills (driver_id, num_of_items, vehical_number, source, destination) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $driverId, $num_of_items, $vehical_num, $source, $destination);
        $stmt->execute();

        if ($stmt->affected_rows <= 0) {
            throw new Exception("Error creating bill: " . $stmt->error);
        }

        // Prepare a SQL INSERT query to insert a new trip
        $sql = "INSERT INTO trips (driver_id, vehical_number, source, destination, date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $driverId, $vehical_num, $source, $destination, $date);
        $stmt->execute();

        if ($stmt->affected_rows <= 0) {
            throw new Exception("Error creating trip: " . $stmt->error);
        }

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback transaction if there is an error
        $conn->rollback();

        echo $e->getMessage();
    }

    $stmt->close();
    $conn->close();
}
?>