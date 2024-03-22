<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <title>Transport Management System</title>
</head>
<body>
    <!-- Navigation Menu section-->
    <?php include 'navbar.php'; ?>

    <!-- topbar section -->
    <div class="topbar" id="topbar">
        <div class="content">
            <div class="text">We make your cargo transport simple</div>
            <button type="button" class="btn btn-warning">Our Services</button>
        </div>
    </div>

    <!-- services section -->
    <div class="container text-center services">
        <div class="row row-cos-auto">
            <hr><hr>
            <h1>Our Services</h1><br><br><br><br>
            <div class="col">
                <i class="fa-solid fa-truck fa-4x"></i>
                <div class="name">Export</div>
            </div>
            <div class="col">
                <i class="fa-solid fa-truck-arrow-right fa-4x"></i>
                <div class="name">Import</div>
            </div>
            <div class="col">
                <i class="fa-solid fa-truck-plane fa-4x"></i>
                <div class="name">Cargo Express</div>
            </div>
            <div class="col">
                <i class="fa-solid fa-dolly fa-4x"></i>
                <div class="name">Information Express</div>
            </div>
            <div class="col">
                <i class="fa-solid fa-clipboard-list fa-4x"></i>
                <div class="name">Warehouse & Distribution</div>
            </div>
            <div class="col">
                <i class="fa-solid fa-handshake fa-4x"></i>
                <div class="name">Brokerage Services</div>
            </div>
        </div><br><hr>
    </div>

    <!-- Global Supply Section -->

    <div class="container text-center supply"><br><br>
        <div class="row">
            <h1>Global Supply</h1><br><br><br><br>
            <div class="col">
                <h3>112 <i class="fa-solid fa-location-dot fa-2x"></i></h3>
                <center><hr width="150px"></center> 
                <h3>Location</h3>
            </div>
            <div class="col">
                <h3>12000 <i class="fa-solid fa-clipboard-user fa-2x"></i></h3>
                <center><hr width="150px"></center>
                 <h3>Employees</h3>
            </div>
            <div class="col">
                <h3>180 <i class="fa-solid fa-earth-americas fa-2x"></i></h3> 
                <center><hr width="150px"></center> 
                <h3>Countries</h3>
            </div>
        </div><br><br><br><br>
        <div class="row">
            <div class="col">
                <h3>15 <i class="fa-solid fa-gears fa-2x"></i></h3> 
                <center><hr width="150px"></center> 
                <h3>Established in</h3>
            </div>
            <div class="col">
                <h3>48 <i class="fa-solid fa-shield-halved fa-2x"></i></h3> 
                <center><hr width="150px"></center> 
                <h3>Warehouse</h3>
            </div>
            <div class="col">
                <h3>1.22 bil <i class="fa-solid fa-indian-rupee-sign fa-2x"></i></h3> 
                <center><hr width="150px"></center> 
                <h3>Revenue</h3>
        </div>
        </div>
    </div>

    <!-- footer section -->
    <?php include 'footer.php'; ?>
    
    <script>
        document.querySelector('.btn').addEventListener('click', function() {
            const container = document.querySelector('.container');
            container.scrollIntoView({ behavior: 'smooth' });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>