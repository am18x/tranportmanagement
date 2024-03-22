<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedIn'])) {
    // Redirect to the index.php page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="transaction_his.css">
    <title>Transaction History</title>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="history">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <button class="btn btn-primary new" data-toggle="modal" data-target="#newItemModal">New</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Transaction ID</th>
                        <th class="col">Bill ID</th>
                        <th class="col">Amount</th>
                        <th class="col">Payment Type</th>
                        <th class="col">Receiver</th>
                        <th class="col">Date</th>
                        <th class="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $sql = 'SELECT * from transaction';
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['bill_id'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . $row['payment_method'] . "</td>";
                            echo "<td>" . $row['receiver'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getTransaction(" . $row['id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a>
                                <a class='btn btn-danger' data-toggle='modal' onclick='deleteTransaction(" . $row['id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                            echo "</tr>"; 
                        }
                    }
                    else {
                        echo "<tr><td colspan='9' style='text-align: center;'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- new modal code -->
    <div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="newItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemModalLabel">New Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newTrans" action="driver_insert_validation.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="transId">Transaction ID</label>
                            <?php
                            include 'db_connection.php';

                                $sql = "SELECT MAX(id) AS max_id FROM transaction";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $next_id = $row['max_id'] + 1;
                            ?>

                            <input type="number" class="form-control" id="transId" name="transId" value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="billId">Bill ID</label>
                            <select class="form-control" id="billId" name="billId">
                                <?php
                                // Fetch bill IDs from the database
                                $sql = "SELECT id FROM bills";
                                $resultBill = $conn->query($sql);

                                if ($resultBill->num_rows > 0) {
                                    // Output each row as an option
                                    while($bill = $resultBill->fetch_assoc()) {
                                        echo "<option value='" . $bill['id'] . "'>" . $bill['id'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No bills available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method</label>
                            <select class="form-control" id="paymentMethod" name="paymentMethod">
                                <option value="UPI">UPI</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="receiver">Receiver</label>
                            <select class="form-control" id="receiver" name="receiver">
                                <?php
                                // Fetch owner IDs and names from the database
                                $sql = "SELECT id, fullname FROM owner";
                                $resultOwner = $conn->query($sql);

                                if ($resultOwner->num_rows > 0) {
                                    // Output each row as an option
                                    while($owner = $resultOwner->fetch_assoc()) {
                                        echo "<option value='" . $owner['id'] . "'>" . $owner['fullname'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No owners available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit modal code -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTrans" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="transId">Transaction ID</label>
                            <input type="number" class="form-control" id="edit_transId" name="edit_transId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="billId">Bill ID</label>
                            <select class="form-control" id="edit_billId" name="edit_billId">
                                <?php
                                // Fetch bill IDs from the database
                                $sql = "SELECT id FROM bills";
                                $resultBill = $conn->query($sql);

                                if ($resultBill->num_rows > 0) {
                                    // Output each row as an option
                                    while($bill = $resultBill->fetch_assoc()) {
                                        echo "<option value='" . $bill['id'] . "'>" . $bill['id'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No bills available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="edit_amount" name="edit_amount">
                        </div>
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method</label>
                            <select class="form-control" id="edit_paymentMethod" name="edit_paymentMethod">
                                <option value="UPI">UPI</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="receiver">Receiver</label>
                            <select class="form-control" id="edit_receiver" name="edit_receiver">
                                <?php
                                // Fetch owner IDs and names from the database
                                $sql = "SELECT id, fullname FROM owner";
                                $resultOwner = $conn->query($sql);

                                if ($resultOwner->num_rows > 0) {
                                    // Output each row as an option
                                    while($owner = $resultOwner->fetch_assoc()) {
                                        echo "<option value='" . $owner['id'] . "'>" . $owner['fullname'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No owners available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="edit_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal code -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the Transaction's Details?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include_once('footer.php'); ?>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- New Driver script -->
    <script>
        $(document).ready(function(){
            $('#newTrans').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'transaction_insert_validation.php',
                    type: 'post',
                    data: formData,
                    success: function(response){
                        if(response.trim() !== '') {
                            $('#error').css({
                                'color': 'red',
                                'font-weight': 'bold'
                            }).addClass('alert alert-danger');
                            $('#newItemModal').animate({ scrollTop: 0 }, 'slow'); // Scroll to top
                        } else {
                            $('#error').css({
                                'color': '',
                                'font-weight': ''
                            });
                        }
                        $('#error').html(response);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            if($('#error').text().trim() !== ''){
                $('#newItemModal').modal('show');
            }
        });
    </script>

    <!-- Edit Transaction script -->
    <script>
        function getTransaction(id) {
            $.ajax({ 
                url: 'get_transaction.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editTrans').replaceWith(response);

                    // Show the modal
                    $('#editItemModal').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to fetch Transaction details');
                }
            });
        }
    </script>

    <!-- Delete Transaction script -->
    <script>
        var transactionIdToDelete;

        function deleteTransaction(id) {
            transactionIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_transaction.php',
                type: 'POST',
                data: { id: transactionIdToDelete },
                success: function(response) {
                    alert('Transaction details deleted successfully');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete transaction details');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>

</body>
</html>