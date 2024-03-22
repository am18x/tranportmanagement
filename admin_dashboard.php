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
    <title>Admin | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin_dash.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="row row-cols-1 row-cols-md-3 g-5 mt-4 ms-4 me-4 mb-5">
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-clock-rotate-left card-img-top fa-5x "></i>
          <div class="card-body">
            <a href="transaction_history.php"><h5 class="card-title">Transaction History</h5></a>
            <p class="card-text">A record of all financial transactions made within a certain period.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-hand-holding-dollar card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="inventory_management.php"><h5 class="card-title">Manage Inventory Details</h5></a>
            <p class="card-text">The process of overseeing and controlling the ordering, storage, and use of components or products.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-id-card card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="driver_management.php"><h5 class="card-title">Manage Driver Details</h5></a>
            <p class="card-text">The task of handling and updating information about drivers, such as their contact information, license details, and work history.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-truck card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="vehical_management.php"><h5 class="card-title">Manage Vehical Details</h5></a>
            <p class="card-text">The task of maintaining and updating information about vehicles, such as their make, model, registration details, and maintenance history.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-file-invoice-dollar card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="bill_management.php"><h5 class="card-title">Manage Bill</h5></a>
            <p class="card-text">The process of creating, sending, tracking, and updating invoices for products or services provided.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-file-invoice card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="driver_payment_history.php"><h5 class="card-title">Driver Payment History</h5></a>
            <p class="card-text">A record of all payments made to drivers, including their salaries, bonuses, and reimbursements.</p>
          </div>
        </div>
      </div>
      <div class="col"></div>
      <div class="col">
        <div class="card pt-3">
          <i class="fa-solid fa-clipboard-list card-img-top fa-5x"></i>
          <div class="card-body">
            <a href="trip_log.php"><h5 class="card-title">Driver Trip Log</h5></a>
            <p class="card-text">A record of all trips made by drivers, including the date, time, distance, and route of each trip.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Section -->
    <?php include_once('footer.php'); ?>
</body>
</html>