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
    <link rel="stylesheet" href="vehical_mng.css">
    <title>Manage Vehical Details</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="vehicals">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <button class="btn btn-primary new" data-toggle="modal" data-target="#newItemModal">New</button>
            </div>
        </div>
        <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Vehical ID</th>
                        <th>Owner</th>
                        <th>Vehical Name</th>
                        <th>Vehical Number</th>
                        <th>Registration Document</th>
                        <th>Insurance Document</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $sql = "SELECT vehical.*, owner.id AS owner_id, owner.fullname AS owner_fullname FROM vehical INNER JOIN owner ON vehical.owner_id = owner.id";
                    $result = $conn->query($sql);

                    $data = [];
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                    } else {
                        echo "0 results";
                    }

                    foreach ($data as $item) {
                        echo "<tr>";
                        echo "<td>{$item['id']}</td>";
                        echo "<td>" . $item['owner_id'] . " - " . $item['owner_fullname'] . "</td>";
                        echo "<td>{$item['vehical_name']}</td>";
                        echo "<td>{$item['vehical_number']}</td>";
                        echo "<td><center><a class='btn btn-primary' href='uploads/vehical/" . $item['registration'] . "?t=" . time() . "' target='_blank'><i class='fas fa-file-pdf'></i></a></center></td>";
                        echo "<td><center><a class='btn btn-primary' href='uploads/vehical/" . $item['insurance'] . "?t=" . time() . "' target='_blank'><i class='fas fa-file-pdf'></i></a></center></td>";
                        echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getVehical(" . $item['id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a></td>";
                        echo "<td><a class='btn btn-danger' data-toggle='modal' onclick='deleteVehical(" . $item['id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                        echo "</tr>";
                    }

                    $conn->close();
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
                    <h5 class="modal-title" id="newItemModalLabel">New Vehical Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newVehical" action="vehical_insert_management.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="vehicalId">Vehical ID</label>
                            <?php
                            include 'db_connection.php';

                                $sql = "SELECT MAX(id) AS max_id FROM vehical";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $next_id = $row['max_id'] + 1;
                            ?>
                            <input type="text" class="form-control" id="vehicalId" name="vehicalId"  value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ownerId">Owner ID</label>
                            <select class="form-control" id="ownerId" name="ownerId">
                                <?php
                                $sql = "SELECT id, fullname FROM owner";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['fullname'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="vehicalName">Vehical Name</label>
                            <input type="text" class="form-control" id="vehicalName" name="vehicalName">
                        </div>
                        <div class="form-group">
                            <label for="vehicalNum">Vehical Number</label>
                            <input type="text" class="form-control" id="vehicalNum" name="vehicalNum">
                        </div>
                        <div class="form-group">
                            <label for="registration">Registration Document</label>
                            <input type="file" class="form-control" id="registration" name="registration">
                        </div>
                        <div class="form-group">
                            <label for="insurance">Insurance Document</label>
                            <input type="file" class="form-control" id="insurance" name="insurance">
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
                    <h5 class="modal-title" id="editItemModalLabel">Edit Vehicle Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editVehical" method="post" enctype="multipart/form-data">
                        <label for="error" class="error" role="alert" id="error"></label>
                        <div class="form-group">
                            <label for="edit_vehicalId">Vehicle ID</label>
                            <input type="text" class="form-control" id="edit_vehicalId" name="edit_vehicalId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_vehicalName">Vehicle Name</label>
                            <input type="text" class="form-control" id="edit_vehicalName" name="edit_vehicalName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_vehicalNum">Vehicle Number</label>
                            <input type="text" class="form-control" id="edit_vehicalNum" name="edit_vehicalNum" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_ownerId">Owner ID</label>
                            <input type="text" class="form-control" id="edit_ownerId" name="edit_ownerId">
                        </div>
                        <div class="form-group">
                            <label for="edit_registration">Registration Document</label>
                            <input type="file" class="form-control" id="edit_registration" name="edit_registration" accept=".pdf">
                        </div>
                        <div class="form-group">
                            <label for="edit_insurance">Insurance Document</label>
                            <input type="file" class="form-control" id="edit_insurance" name="edit_insurance" accept=".pdf">
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
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Vehical Details</h5>
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

    <!-- New Vehical script -->
    <script>
        $(document).ready(function(){
            $('#newVehical').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'vehical_insert_management.php',
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
        function getVehical(id) {
            $.ajax({
                url: 'get_vehical.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editVehical').replaceWith(response);

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
        var vehicalIdToDelete;

        function deleteVehical(id) {
            vehicalIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_vehical.php',
                type: 'POST',
                data: { id: vehicalIdToDelete },
                success: function(response) {
                    alert('Vehical deleted successfully');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete vehical');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>

</body>
</html>