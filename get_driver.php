<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT driver.*, driver_payment.advance 
        FROM driver 
        INNER JOIN driver_payment ON driver.id = driver_payment.driver_id 
        WHERE driver.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the driver details filled in
    $form = '
    <form id="editDriver" action="edit_driver.php" method="post" enctype="multipart/form-data">
        <label for="error" class="error" role="alert" id="error"></label>
        <div class="form-group">
            <label for="edit_driverId">Driver ID</label>
            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId" value="'.$row['id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_driverName">Driver Name</label>
            <input type="text" class="form-control" id="edit_driverName" name="edit_driverName" value="'.$row['fullname'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_username">Driver Username</label>
            <input type="text" class="form-control" id="edit_username" name="edit_username" value="'.$row['username'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_email">Driver Email ID</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" value="'.$row['email'].'">
        </div>
        <div class="form-group">
            <label for="edit_address">Address</label>
            <textarea type="text" class="form-control" id="edit_address" name="edit_address">'.$row['address'].'</textarea>
        </div>
        <div class="form-group">
            <label for="edit_phone">Phone Number</label>
            <input type="text" class="form-control" id="edit_phone" name="edit_phone" value="'.$row['phone_no'].'">
        </div>
        <div class="form-group">
            <label for="edit_salary">Salary</label>
            <input type="number" class="form-control" id="edit_salary" name="edit_salary" value="'.$row['salary'].'">
        </div>
        <div class="form-group">
            <label for="edit_advanceAmount">Advance Amount</label>
            <input type="number" class="form-control" id="edit_advanceAmount" name="edit_advanceAmount" value="'.$row['advance'].'">
        </div>
        <div class="form-group">
            <label for="license">Driver License</label>
            <input type="file" class="form-control" id="edit_license" name="edit_license" accept=".pdf">
        </div>
        
        <div class="form-group">
            <label for="edit_vehical_id">Vehicle ID</label>';

        include "db_connection.php";

        $driver_id = $row['id'];
        $sql_driver = "SELECT vehical_id FROM driver WHERE id = $driver_id";
        $result_driver = $conn->query($sql_driver);
        $row_driver = $result_driver->fetch_assoc();
        $current_vehical_id = $row_driver["vehical_id"];

        $sql = "SELECT id, vehical_number FROM vehical";
        $result = $conn->query($sql);

        $form .= '<select class="form-select form-control" id="edit_vehical_id" name="edit_vehical_id" aria-label="Default select example">
            <option>Select vehicle</option>';
        
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $selected = ($row["id"] == $current_vehical_id) ? "selected" : "";
                    $form .= "<option value='" . $row["id"] . "' " . $selected . ">" . $row["id"] . " " . $row["vehical_number"] . "</option>";
                }
            }
            $form .= '</select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No driver found with the given id';
}
?>