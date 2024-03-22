<?php
include 'db_connection.php';

$id = $_POST['id'];
$sql = "SELECT * FROM transaction WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Create a HTML form with the transaction details filled in
    $form = '
    <form id="editTransaction" action="edit_transaction.php" method="post">
        <label for="error" class="error" role="alert" id="error"></label>
        <div class="form-group">
            <label for="edit_transId">Transaction ID</label>
            <input type="text" class="form-control" id="edit_transId" name="edit_transId" value="'.$row['id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_billId">Bill ID</label>
            <input type="text" class="form-control" id="edit_billId" name="edit_billId" value="'.$row['bill_id'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_amount">Amount</label>
            <input type="text" class="form-control" id="edit_amount" name="edit_amount" value="'.$row['amount'].'">
        </div>
        <div class="form-group">
            <label for="edit_paymentMethod">Payment Method</label>
            <select class="form-control" id="edit_paymentMethod" name="edit_paymentMethod">
                <option value="UPI" echo ($row["payment_method"] == "UPI") ? "selected" : ""; >UPI</option>
                <option value="Cash" echo ($row["payment_method"] == "Cash") ? "selected" : ""; >Cash</option>
                <option value="Cheque" echo ($row["payment_method"] == "Cheque") ? "selected" : ""; >Cheque</option>
            </select>
        </div>
        <div class="form-group">
            <label for="edit_receiver">Receiver</label>
            <input type="text" class="form-control" id="edit_receiver" name="edit_receiver" value="'.$row['receiver'].'" readonly>
        </div>
        <div class="form-group">
            <label for="edit_date">Date</label>
            <input type="date" class="form-control" id="edit_date" name="edit_date" value="'.$row['date'].'">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>';

    echo $form;
} else {
    echo 'No transaction found with the given id';
}
?>