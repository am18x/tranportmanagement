<?php
session_start();

// Check if the user is not logged in as admin or driver
if (!isset($_SESSION['isLoggedInAdmin']) && !isset($_SESSION['isLoggedInDriver'])) {
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
    <link rel="stylesheet" href="driver_payment_his.css">
    <title>Payment History</title>
</head>
<body>
    <?php include 'navbar.php'; ?> 

    <section class="history">
        <?php
            if(isset($_SESSION['isLoggedInAdmin']) && $_SESSION['isLoggedInAdmin'] == true) {
                echo "<div class='d-flex flex-row-reverse'>
                        <div class='p-2'>
                            <button class='btn btn-primary new' data-toggle='modal' data-target='#newItemModal'>New</button>
                        </div>
                    </div>";
            }
        ?>
        <div class="table-responsive">    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Driver ID</th>
                        <th>Salary</th>
                        <th>Amount Payed</th>
                        <th>Remaining</th>
                        <th>Payer ID</th>
                        <th>Date</th>
                        <?php
                        if (isset($_SESSION['isLoggedInAdmin']) && $_SESSION['isLoggedInAdmin'] == true) {
                            echo "<th>Edit</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'db_connection.php';

                        $sql = "SELECT * FROM driver_payment";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['driver_id'] . "</td>";
                                echo "<td>" . $row['salary'] . "</td>";
                                echo "<td>" . $row['amount_payed'] . "</td>";
                                echo "<td>" . $row['remaining'] . "</td>";
                                echo "<td>" . $row['payer_id'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                
                                if (isset($_SESSION['isLoggedInAdmin']) && $_SESSION['isLoggedInAdmin'] == true) {
                                    echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getPayment(" . $row['id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a>
                                    <a class='btn btn-danger' data-toggle='modal' onclick='deletePayment(" . $row['id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                                }
                                
                                echo "</tr>"; 
                            }
                        }
                        else {
                            echo "<tr><td colspan='8' style='text-align: center;'>No data found</td></tr>";
                        }
                    ?>
                </tbody>
            </table></div>
        
    </section>

    <!-- new modal code -->
    <div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="newItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemModalLabel">New Driver Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newDriverPayment" action="driver_payment_insert_validation.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="paymentId">Payment ID</label>
                            <?php
                            include 'db_connection.php';

                            // Fetch the maximum payment_id from the driver_payment_history table
                            $sql = "SELECT MAX(id) AS max_id FROM driver_payment";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $max_id = $row['max_id'];

                            // The next available ID is the maximum ID + 1
                            $next_id = $max_id + 1;
                            ?>

                            <input type="text" class="form-control" id="paymentId" name="paymentId" value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="driverId">Driver ID</label>
                            <?php
                            include 'db_connection.php';

                            // Fetch all driver IDs from the driver table
                            $sql = "SELECT id FROM driver";
                            $result = $conn->query($sql);
                            ?>

                            <select class="form-control" id="driverId" name="driverId">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary">
                        </div>
                        <div class="form-group">
                            <label for="amountPayed">Amount Payed</label>
                            <input type="number" class="form-control" id="amountPayed" name="amountPayed">
                        </div>

                        <script>
                        document.getElementById('salary').addEventListener('input', calculateRemaining);
                        document.getElementById('amountPayed').addEventListener('input', calculateRemaining);

                        function calculateRemaining() {
                            var salary = parseFloat(document.getElementById('salary').value) || 0;
                            var amountPayed = parseFloat(document.getElementById('amountPayed').value) || 0;
                            var remaining = salary - amountPayed;
                            document.getElementById('remaining').value = remaining.toFixed(2);
                        }
                        </script>

                        <div class="form-group">
                            <label for="remaining">Remaining</label>
                            <input type="number" class="form-control" id="remaining" name="remaining" readonly>
                        </div>
                        <div class="form-group">
                            <label for="payerId">Payer ID</label>
                            <?php
                            include 'db_connection.php';

                            // Fetch all owner IDs from the owner table
                            $sql = "SELECT id FROM owner";
                            $result = $conn->query($sql);
                            ?>

                            <select class="form-control" id="payerId" name="payerId">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                                <?php endwhile; ?>
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
                    <h5 class="modal-title" id="editItemModalLabel">Edit Driver Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDriverPayment" method="post" enctype="multipart/form-data">
                        <label for="error" class="error" role="alert" id="error"></label>
                        <div class="form-group">
                            <label for="edit_paymentId">Payment ID</label>
                            <input type="text" class="form-control" id="edit_paymentId" name="edit_paymentId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_driverId">Driver ID</label>
                            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_salary">Salary</label>
                            <input type="number" class="form-control" id="edit_salary" name="edit_salary">
                        </div>
                        <div class="form-group">
                            <label for="edit_amountPayed">Amount Payed</label>
                            <input type="number" class="form-control" id="edit_amountPayed" name="edit_amountPayed">
                        </div>
                        <div class="form-group">
                            <label for="edit_remaining">Remaining</label>
                            <input type="number" class="form-control" id="edit_remaining" name="edit_remaining" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_payerId">Payer ID</label>
                            <?php
                                include 'db_connection.php';

                                $sql = "SELECT id FROM owner";
                                $result = $conn->query($sql);
                            ?>

                            <select class="form-select form-control" id="edit_payerId" name="edit_payerId" aria-label="Default select example">
                                <option selected>Select payer</option>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="edit_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Driver Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the Driver's Details?
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
            $('#newDriverPayment').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'driver_payment_insert_validation.php',
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

    <!-- Edit Driver script -->
    <script>
        function getPayment(id) {
            $.ajax({
                url: 'get_payment.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editDriverPayment').replaceWith(response);

                    // Show the modal
                    $('#editItemModal').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to fetch driver details');
                }
            });
        }
    </script>

    <!-- Delete Driver script -->
    <script>
        var paymentIdToDelete;

        function deletePayment(id) {
            paymentIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_payment.php',
                type: 'POST',
                data: { id: paymentIdToDelete },
                success: function(response) {
                    alert('Payment deleted successfully');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete payment details');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>

</body>
</html>