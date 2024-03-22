<?php
    include 'db_connection.php';

    if(isset($_POST['username'])){
        session_start();

        $uname = $_POST['username'];
        $password = $_POST['password'];

        $_SESSION['username'] = $uname;
        $_SESSION['password'] = $password;

        // Initialize error messages
        $_SESSION['error'] = '';

         //check the username and password matches in database
        $sql = "SELECT * FROM owner WHERE username = '$uname' AND password = '$password'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $_SESSION['isLoggedIn'] = true; 
            $_SESSION['isLoggedInAdmin'] = true;
            header('Location: admin_dashboard.php');
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header('Location: admin_login.php');
        }
    }
?>