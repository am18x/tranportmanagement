<!-- write code to connect the database on localhost using xampp and SQL -->
<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "transport_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
      die('Connection Failed : '.$conn->connect_error);
    }
?>