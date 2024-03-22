<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top object-fit-fill border rounded">
                Transport Management System
            </a>

            <ul class="nav nav-underline justify-content-end">
                <?php
                    if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
                        // If logged in, show the logout button
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        ';
                    } else {
                        // If not logged in, show the login dropdown
                        echo '
                            <li class="nav-item dropdown">
                                <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">Login</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="admin_login.php">Admin Login</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="driver_login.php">Driver Login</a>
                                    </li>
                                </ul>
                            </li>
                        ';
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>
