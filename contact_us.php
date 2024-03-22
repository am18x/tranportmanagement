<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="contact_us.css">
    <title>Contact Us</title>
</head>
<body>
    <!-- Navbar Menu Section -->
    <?php include 'navbar.php'; ?>

    <!-- Contact Us Form Section -->
    <div class="form">
        <center><h1>Contact Us</h1></center>
        <br>
        <form>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationDefault01">First name</label>
                    <input type="text" class="form-control" id="validationDefault01" placeholder="First name" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Last name</label>
                    <input type="text" class="form-control" id="validationDefault02" placeholder="Last name" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Country</label>
                    <input type="text" class="form-control" id="validationDefault03" placeholder="Country" required>
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-md-4 mb-3">
                    <label for="validationDefault04">State</label>
                    <input type="text" class="form-control" id="validationDefault04" placeholder="State" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault03">City</label>
                    <input type="text" class="form-control" id="validationDefault03" placeholder="City" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Zip</label>
                    <input type="text" class="form-control" id="validationDefault05" placeholder="Zip" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <label for="validationDefault04">Message</label>
                    <textarea class="form-control" id="validationDefault04" placeholder="Message" required></textarea>
                </div>
            </div>
            <center><button class="btn btn-primary" type="submit">Submit form</button></center>
        </form>
    </div>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>

</body>
</html>