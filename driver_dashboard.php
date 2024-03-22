<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedInDriver'])) {
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
    <title>Driver | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="driver_dash.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="row row-cols-1 row-cols-md-4 g-5 mt-4 ms-4 me-4 mb-5">
      <div class="col"></div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-file-invoice card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="driver_payment_history.php"><h5 class="card-title">Payment History</h5></a>
            <p class="card-text">A record of all payments made to drivers, including their salaries, bonuses, and reimbursements.</p>
          </div>
        </div> 
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-clipboard-list card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="trip_log.php"><h5 class="card-title">Trip Log</h5></a>
            <p class="card-text">A record of all trips made by drivers, including the date, time, distance, and route of each trip.</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Footer Section -->
    <?php include_once('footer.php'); ?>
</body>
</html>