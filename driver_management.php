<?php
session_start();

if(isset($_SESSION['error'])) {
    echo '<span class="error alert alert-danger" role="alert" id="error">' . $_SESSION['error'] . '</span>';
    unset($_SESSION['error']); // Clear the error message
}

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
    <title>Manage Driver Details</title>
    <link rel="stylesheet" href="driver_mng.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="history">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <button class="btn btn-primary new" data-toggle="modal" data-target="#newItemModal">New</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Driver ID</th>
                        <th>Driver Name</th>
                        <th>Address</th>
                        <th>Phone No.</th>
                        <th>Salary</th>
                        <th>Vehical Number</th>
                        <th><center>License</center></th>
                        <th><center>Edit</center></th>
                        <th><center>Delete</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'db_connection.php';

                        $sql = "SELECT driver.*, vehical.vehical_number FROM driver 
                            LEFT JOIN vehical ON driver.vehical_id = vehical.id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fullname'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['phone_no'] . "</td>";
                                echo "<td>" . $row['salary'] . "</td>";
                                echo "<td>" . $row['vehical_number'] . "</td>";
                                echo "<td><center><a class='btn btn-primary' href='uploads/" . $row['license'] . "?t=" . time() . "' target='_blank'><i class='fas fa-file-pdf'></i></a></center></td>";
                                echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getDriver(" . $row['id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a></td>";
                                echo "<td><a class='btn btn-danger' data-toggle='modal' onclick='deleteDriver(" . $row['id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                                echo "</tr>"; 
                            }
                        }
                        else {
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
                    <h5 class="modal-title" id="newItemModalLabel">New Driver Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newDriver" action="driver_insert_validation.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="driverId">Driver ID</label>
                            <?php
                            include 'db_connection.php';

                                $sql = "SELECT MAX(id) AS max_id FROM driver";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $next_id = $row['max_id'] + 1;
                            ?>

                            <input type="text" class="form-control" id="driverId" name="driverId" value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="driverName">Driver Name</label>
                            <input type="text" class="form-control" id="driverName" name="driverName">
                        </div>
                        <div class="form-group">
                            <label for="username">Driver Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="email">Driver Email ID</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea type="text" class="form-control" id="address" name="address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary">
                        </div>
                        <div class="form-group">
                            <label for="advanceAmount">Advance Amount</label>
                            <input type="number" class="form-control" id="advanceAmount" name="advanceAmount">
                        </div>
                        <div class="form-group">
                            <label for="license">Driver License</label>
                            <input type="file" class="form-control" id="license" name="license" accept=".pdf">
                        </div>
                        <div class="form-group">
                            <label for="doc_id">Vehical ID</label>
                            <?php
                                include 'db_connection.php';

                                $sql = "SELECT id, vehical_number FROM vehical";
                                $result = $conn->query($sql);
                            ?>

                            <select class="form-select form-control" id="vehical_id" name="vehical_id" aria-label="Default select example">
                                <option selected>Select vehicle</option>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " " . $row['vehical_number'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
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
                    <form id="editDriver" method="post" enctype="multipart/form-data">
                        <label for="error" class="error" role="alert" id="error"></label>
                        <div class="form-group">
                            <label for="edit_driverId">Driver ID</label>
                            <input type="text" class="form-control" id="edit_driverId" name="edit_driverId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_driverName">Driver Name</label>
                            <input type="text" class="form-control" id="edit_driverName" name="edit_driverName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_username">Driver Username</label>
                            <input type="text" class="form-control" id="edit_username" name="edit_username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Driver Email ID</label>
                            <input type="email" class="form-control" id="edit_email" name="edit_email">
                        </div>
                        <div class="form-group">
                            <label for="edit_address">Address</label>
                            <textarea type="text" class="form-control" id="edit_address" name="edit_address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone">Phone Number</label>
                            <input type="text" class="form-control" id="edit_phone" name="edit_phone">
                        </div>
                        <div class="form-group">
                            <label for="edit_salary">Salary</label>
                            <input type="number" class="form-control" id="edit_salary" name="edit_salary">
                        </div>
                        <div class="form-group">
                            <label for="edit_advanceAmount">Advance Amount</label>
                            <input type="number" class="form-control" id="edit_advanceAmount" name="edit_advanceAmount">
                        </div>
                        <div class="form-group">
                            <label for="license">Driver License</label>
                            <input type="file" class="form-control" id="edit_license" name="edit_license" accept=".pdf">
                        </div>
                        <div class="form-group">
                            <label for="doc_id">Vehical ID</label>
                            <?php
                                include 'db_connection.php';

                                $sql = "SELECT id, vehical_number FROM vehical";
                                $result = $conn->query($sql);
                            ?>

                            <select class="form-select form-control" id="edit_vehical_id" name="edit_vehical_id" aria-label="Default select example">
                                <option selected>Select vehicle</option>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " " . $row['vehical_number'] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
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
            $('#newDriver').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'driver_insert_validation.php',
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
        function getDriver(id) {
            $.ajax({
                url: 'get_driver.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editDriver').replaceWith(response);

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
        var driverIdToDelete;

        function deleteDriver(id) {
            driverIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_driver.php',
                type: 'POST',
                data: { id: driverIdToDelete },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete driver');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>

</body>
</html>