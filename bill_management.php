<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedInAdmin'])) {
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
    <link rel="stylesheet" href="bill_mng.css">
    <title>Manage Bill's Details</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="bills">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <button class="btn btn-primary new" data-toggle="modal" data-target="#newItemModal">New</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Driver ID</th>
                        <th>Number of Items Carried</th>
                        <th>Vehical Number</th>
                        <th>Source</th>
                        <th>Destiation</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $sql = "SELECT * FROM bills";
                    $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['driver_id']}</td>";
                                echo "<td>{$row['num_of_items']}</td>";
                                echo "<td>{$row['vehical_number']}</td>";
                                echo "<td>{$row['source']}</td>";
                                echo "<td>{$row['destination']}</td>";
                                echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getBill(" . $row['id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a>
                                    <a class='btn btn-danger' data-toggle='modal' onclick='deleteBill(" . $row['id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align: center;'>No data found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- new modal code -->
    <div class="modal fade" id="newItemModal" tabindex="-1" role="dialog" aria-labelledby="newItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemModalLabel">New Bill</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newBill" action="bill_insert_validation.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="billId">Bill ID</label>
                            <?php
                            include 'db_connection.php';

                                $sql = "SELECT MAX(id) AS max_id FROM bills";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $next_id = $row['max_id'] + 1;
                            ?>
                            <input type="text" class="form-control" id="billId" name="billId" value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="driverId">Driver ID</label>
                            <select class="form-control" id="driverId" name="driverId">
                                <?php
                                // Fetch driver IDs and fullnames from the database
                                $sql = "SELECT id, fullname FROM driver";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output each row as an option
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['fullname'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No drivers available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="numOfItems">Number of Items Carrying</label>
                            <input type="number" class="form-control" id="numOfItems" name="numOfItems">
                        </div>
                        <div class="form-group">
                            <label for="vehicalNum">Vehicle Number</label>
                            <select class="form-control" id="vehicalNum" name="vehicalNum">
                                <?php
                                // Fetch vehicle numbers from the database
                                $sql = "SELECT vehical_number FROM vehical";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output each row as an option
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['vehical_number'] . "'>" . $row['vehical_number'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No vehicles available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="source">Source</label>
                            <input type="text" class="form-control" id="source" name="source">
                        </div>
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <input type="text" class="form-control" id="destination" name="destination">
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
                    <h5 class="modal-title" id="editItemModalLabel">Edit Bill's Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editBill" method="post" enctype="multipart/form-data">
                        <label for="error" class="error" role="alert" id="error"></label>
                        <div class="form-group">
                            <label for="billId">Bill ID</label>
                            <input type="text" class="form-control" id="edit_billId" name="edit_billId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="driverId">Driver ID</label>
                            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId">
                        </div>
                        <div class="form-group">
                            <label for="numOfItems">Number of Items Carrying</label>
                            <input type="text" class="form-control" id="edit_numOfItems" name="edit_numOfItems">
                        </div>
                        <div class="form-group">
                            <label for="vehicalNum">Vehical Number</label>
                            <input type="number" class="form-control" id="edit_vehicalNum" name="edit_vehicalNum">
                        </div>
                        <div class="form-group">
                            <label for="source">Source</label>
                            <input type="number" class="form-control" id="edit_source" name="edit_source">
                        </div>
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <input type="number" class="form-control" id="edit_destination" name="edit_destination">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this modal code -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Bill's Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the Bill's Details?
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

    <!-- Add this script to handle the delete confirmation -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- New Driver script -->
    <script>
        $(document).ready(function(){
            $('#newBill').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'bill_insert_validation.php',
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
        function getBill(id) {
            $.ajax({
                url: 'get_bill.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editBill').replaceWith(response);

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
        var billIdToDelete;

        function deleteBill(id) {
            billIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_bill.php',
                type: 'POST',
                data: { id: billIdToDelete },
                success: function(response) {
                    alert('Bill Deleted Successfully!');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete bill details');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>
</body>
</html>