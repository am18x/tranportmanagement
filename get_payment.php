<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT * FROM driver_payment WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the payment details filled in
    $form = '
    <form id="editPayment" action="edit_payment.php" method="post" enctype="multipart/form-data">
        <label for="error" class="error" role="alert" id="error"></label>
        <div class="form-group">
            <label for="edit_paymentId">Payment ID</label>
            <input type="text" class="form-control" id="edit_paymentId" name="edit_paymentId" value="'.$row['id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_driverId">Driver ID</label>
            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId" value="'.$row['driver_id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_salary">Salary</label>
            <input type="number" class="form-control" id="edit_salary" name="edit_salary" value="'.$row['salary'].'">
        </div>
        <div class="form-group">
            <label for="edit_amountPayed">Amount Payed</label>
            <input type="number" class="form-control" id="edit_amountPayed" name="edit_amountPayed" value="'.$row['amount_payed'].'">
        </div>

        <script>
            document.getElementById("edit_salary").addEventListener("input", calculateRemaining);
            document.getElementById("edit_amountPayed").addEventListener("input", calculateRemaining);

            function calculateRemaining() {
                var salary = parseFloat(document.getElementById("edit_salary").value) || 0;
                var amountPayed = parseFloat(document.getElementById("edit_amountPayed").value) || 0;
                var remaining = salary - amountPayed;
                document.getElementById("edit_remaining").value = remaining.toFixed(2);
            }
        </script>

        <div class="form-group">
            <label for="edit_remaining">Remaining</label>
            <input type="number" class="form-control" id="edit_remaining" name="edit_remaining" readonly>
        </div>
        <div class="form-group">
            <label for="edit_payerId">Payer ID</label>';

        include "db_connection.php";

        $sql = "SELECT id FROM owner";
        $result = $conn->query($sql);

        $form .= '<select class="form-select form-control" id="edit_payerId" name="edit_payerId" aria-label="Default select example">
            <option>Select payer</option>';
        
            if ($result->num_rows > 0) {
                while($row_owner = $result->fetch_assoc()) {
                    $selected = ($row_owner["id"] == $row["payer_id"]) ? "selected" : "";
                    $form .= "<option value='" . $row_owner["id"] . "' " . $selected . ">" . $row_owner["id"] . "</option>";
                }
            }
            $form .= '</select>
        </div>
        <div class="form-group">
            <label for="edit_date">Date</label>
            <input type="date" class="form-control" id="edit_date" name="edit_date" value="'.$row['date'].'">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No payment found with the given id';
}
?>