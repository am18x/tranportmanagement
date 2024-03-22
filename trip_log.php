<?php
session_start();

// Check if the user is not logged in
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
    <link rel="stylesheet" href="trip_log.css">
    <title>Driver's Trip Log</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="trips">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Trip ID</th>
                    <th>Driver ID</th>
                    <th>Vehical Number</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include 'db_connection.php';

                    $sql = "SELECT * FROM trips";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['driver_id'] . "</td>";
                            echo "<td>" . $row['vehical_number'] . "</td>";
                            echo "<td>" . $row['source'] . "</td>";
                            echo "<td>" . $row['destination'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No trips found</td></tr>";
                    }

                    $conn->close();

                ?>
            </tbody>
        </table>
    </section>

    <!-- Footer Section -->
    <?php include_once('footer.php'); ?>

    <!-- Add this script to handle the delete confirmation -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>