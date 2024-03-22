<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin_login.css">

    <?php
        session_start();
    ?>
</head>
<body>

    <div class="wrapper">
      <form action="admin_reg_process.php" method="POST">
        <h2>Admin Registration</h2>
        <span class="error <?php echo isset($_SESSION['error']) && $_SESSION['error'] != '' ? 'alert alert-danger' : ''; ?>" role="alert" id="error"><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></span>
        <div class="input-field">
          <input type="text" name="username" autocomplete="off" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
          <label>Enter your Username</label>
        </div>
        <div class="input-field">
          <input type="text" name="fullname" autocomplete="off" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>">
          <label>Enter your Full Name</label>
        </div>
        <div class="input-field">
          <input type="email" name="email" autocomplete="off" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
          <label>Enter your email</label>
        </div>
        <div class="input-field">
          <input type="text" name="phone" autocomplete="off" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>">
          <label>Enter your Phone Number</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" autocomplete="off" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ''; ?>">
          <label>Enter your password</label>
        </div>
        <div class="input-field">
          <input type="password" name="cpassword" autocomplete="off" value="<?php echo isset($_SESSION['cpassword']) ? $_SESSION['cpassword'] : ''; ?>">
          <label>Confirm your password</label>
        </div>
        <button type="submit">Log In</button>
      </form>
    </div>
    
    <?php 
        $_SESSION['error'] = '';
    ?> 
    
</body>
</html>