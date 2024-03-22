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
    <link rel="stylesheet" href="inventory_mng.css">
    <title>Inventory Management</title>
</head>
<body>
    
    <?php include 'navbar.php'; ?>

    <section class="inventory">
        <div class="d-flex flex-row-reverse">
            <div class="p-2">
                <button class="btn btn-primary new" data-toggle="modal" data-target="#newItemModal">New</button>
            </div>
        </div>
        <?php
        include 'db_connection.php';

        $sql = "SELECT * FROM inventory";
        $result = $conn->query($sql);
        ?>
        <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Value</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['product_id']}</td>";
                            echo "<td>{$row['product_name']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td>{$row['quantity']}</td>";
                            echo "<td>{$row['total_value']}</td>";
                            echo "<td><a class='btn btn-primary' data-toggle='modal' onclick='getInventory(" . $row['product_id'] . ")' data-target='#editItemModal'><i class='fas fa-edit'></i></a>
                                <a class='btn btn-danger' data-toggle='modal' onclick='deleteInventory(" . $row['product_id'] . ")' data-target='#deleteItemModal'><i class='fa-solid fa-trash-can'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'><center>No data found</center></td></tr>";
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
                    <h5 class="modal-title" id="newItemModalLabel">New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newInventory" action="inventory_mng_validation.php" method="post">
                        <label for="error" class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></label>
                        <div class="form-group">
                            <label for="productId">Product ID</label>
                            <?php
                            include 'db_connection.php';

                                $sql = "SELECT MAX(product_id) AS max_id FROM inventory";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $next_id = $row['max_id'] + 1;
                            ?>

                            <input type="text" class="form-control" id="productId" name="productId" value="<?php echo $next_id; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" oninput="calTotalValue()">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" oninput="calTotalValue()">
                        </div>
                        <div class="form-group">
                            <label for="totalValue">Total Value</label>
                            <input type="number" class="form-control" id="totalValue" name="totalValue" readonly>
                        </div>

                        <script>
                        function calTotalValue() {
                            var price = document.getElementById('price').value;
                            var quantity = document.getElementById('quantity').value;
                            var totalValue = price * quantity;
                            document.getElementById('totalValue').value = totalValue;
                        }
                        </script>
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
                    <h5 class="modal-title" id="editItemModalLabel">Edit Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editInventory" method="post" enctype="multipart/form-data">
                        <label for="error" class="error" role="alert" id="error"></label>
                        <div class="form-group">
                            <label for="editProductId">Product ID</label>
                            <input type="text" class="form-control" id="editProductId" name="editProductId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editProductName">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="editProductName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editPrice">Price</label>
                            <input type="number" class="form-control" id="editPrice" name="editPrice" oninput="calculateTotalValue()">
                        </div>
                        <div class="form-group">
                            <label for="editQuantity">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="editQuantity" oninput="calculateTotalValue()">
                        </div>
                        <div class="form-group">
                            <label for="editTotalValue">Total Value</label>
                            <input type="number" class="form-control" id="editTotalValue" name="editTotalValue" readonly>
                        </div>

                        <script>
                        function calculateTotalValue() {
                            var price = document.getElementById('editPrice').value;
                            var quantity = document.getElementById('editQuantity').value;
                            var totalValue = price * quantity;
                            document.getElementById('editTotalValue').value = totalValue;
                        }
                        </script>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete modal code -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the Inventory's Details?
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

    <!-- New Inventory script -->
    <script>
        $(document).ready(function(){
            $('#newInventory').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'inventory_mng_validation.php',
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

    <!-- Edit Inventory script -->
    <script>
        function getInventory(id) {
            $.ajax({
                url: 'get_inventory.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Replace the existing form with the one returned by the AJAX request
                    $('#editInventory').replaceWith(response);

                    // Show the modal
                    $('#editItemModal').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to fetch inventory details');
                }
            });
        }
    </script>

    <!-- Delete Inventory script -->
    <script>
        var inventoryIdToDelete;

        function deleteInventory(id) {
            inventoryIdToDelete = id;
        }

        function confirmDelete() {
            $.ajax({
                url: 'delete_inventory.php',
                type: 'POST',
                data: { id: inventoryIdToDelete },
                success: function(response) {
                    alert('Inventory Deleted');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to delete inventory details');
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDelete').click(confirmDelete);
        });
    </script>
</body>
</html>