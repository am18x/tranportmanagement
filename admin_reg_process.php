
<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "transport_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
      die('Connection Failed : '.$conn->connect_error);
    }

    if(isset($_POST['username'])){
        session_start();

        $uname = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        $_SESSION['username'] = $uname;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['password'] = $password;
        $_SESSION['cpassword'] = $cpassword;

        // Initialize error messages
        $_SESSION['error'] = '';

        // Check if any field is empty
        if(empty($uname)) {
            $_SESSION['error'] = "Username is required";
        }
        if(empty($fullname)) {
            $_SESSION['error'] = "Full Name is required";
        }
        if(empty($email)) {
            $_SESSION['error'] = "Email is required";
        }
        if(empty($phone)) {
            $_SESSION['error'] = "Phone number is required";
        }
        if(empty($password)) {
            $_SESSION['error'] = "Password is required";
        }
        if(empty($cpassword)) {
            $_SESSION['error'] = "Confirm Password is required";
        }

        // Check if password and confirm password match
        if($password !== $cpassword){
            $_SESSION['error'] = "Password and Confirm Password do not match";
        }
        // Check if username meets the requirements
        else if(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/", $uname)) {
            $_SESSION['error'] = "Username must contain at least one capital letter, one number, one symbol, and be at least 8 characters long";
        }
        // Check if full name must contains only letters and white space and have at least 4 characters
        else if(!preg_match("/^[a-zA-Z ]{4,}$/", $fullname)) {
            $_SESSION['error'] = "Full Name must contain only letters and white space and have at least 4 characters";
        }
        // Check if email is valid
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email is invalid";
        }
        // Check if phone number is valid
        else if(!preg_match("/^\d{10}$/", $phone)) {
            $_SESSION['error'] = "Phone number must be 10 digits long and contain only numbers";
        }

        else {
            echo "Password and Confirm Password match";
            $sql = "INSERT INTO owner (username, fullname, email, phone_no, password) VALUES ('$uname', '$fullname', '$email', '$phone', '$password')";

            if($conn->query($sql) === TRUE){
                echo "New record created successfully";
                unset($_SESSION['username']);
                unset($_SESSION['fullname']);
                unset($_SESSION['email']);
                unset($_SESSION['phone']);
                unset($_SESSION['password']);
                unset($_SESSION['cpassword']);
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        header('Location: admin_login.php');
    }
?>