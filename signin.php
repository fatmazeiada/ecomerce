<?php
require_once 'config.php'; // Includes session_start()

$login_identifier = $password = "";
$errors = [];

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if identifier (email or phone) is empty
    if (empty(trim($_POST["login_identifier"]))) {
        $errors['login_identifier'] = "Please enter email or phone number.";
    } else {
        $login_identifier = trim($_POST["login_identifier"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($errors)) {
        // Prepare a select statement (check both email and phone)
        $sql = "SELECT id, first_name, last_name, email, phone, password, user_type FROM users WHERE email = ? OR phone = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $login_identifier, $login_identifier);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if account exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $first_name, $last_name, $email, $phone, $hashed_password, $user_type);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            // session_start(); // Already started in config.php

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["user_email"] = $email;
                            $_SESSION["user_phone"] = $phone;
                            $_SESSION["user_first_name"] = $first_name;
                            $_SESSION["user_last_name"] = $last_name;
                             $_SESSION["user_type"] = $user_type; // Store user type (admin/customer)

                            // Redirect user to home page (or dashboard if admin)
                            if ($user_type == 'admin') {
                                // Redirect to admin dashboard (create this later)
                                header("location: admin/index.php"); // Assuming admin area is in /admin
                            } else {
                                header("location: index.php");
                            }
                            exit;
                        } else {
                            // Password is not valid
                            $errors['login'] = "Invalid email/phone or password.";
                        }
                    }
                } else {
                    // Account doesn't exist
                    $errors['login'] = "Invalid email/phone or password.";
                }
            } else {
                $errors['db_error'] = "Oops! Something went wrong. Please try again later.";
                 error_log("Signin Execute Error: " . $stmt->error);
            }

            // Close statement
            $stmt->close();
        } else {
             $errors['db_error'] = "Database error preparing statement.";
             error_log("Signin Prepare Error: " . $mysqli->error);
        }
    }

    // Close connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hexashop - Sign In</title>
    <!-- Add CSS files similar to signup.php -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <style>
        .form-container { max-width: 500px; margin: 50px auto; padding: 30px; border: 1px solid #eee; border-radius: 8px; background-color: #fff; }
        .form-group { margin-bottom: 1rem; }
        .form-control.is-invalid { border-color: #dc3545; }
        .invalid-feedback { color: #dc3545; font-size: 0.875em; display: block; }
        .alert { margin-top: 1rem; }
        .auth-link { margin-top: 15px; text-align: center; }
    </style>
</head>
<body>
    <!-- Header -->
     <header style="background-color: black; position: fixed; width: 100%; top: 0; left: 0; z-index: 1000; padding: 10px 0;">
         <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
             <a href="index.php" class="logo"><img src="assets/images/white-logo.png" style="height: 50px;"></a>
             <nav>
                 <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
                    <li><a href="index.php#home" style="color: white; text-decoration: none;">BESTCOLLECTION</a></li>
                    <li><a href="index.php#men" style="color: white; text-decoration: none;">MEN</a></li>
                    <li><a href="index.php#women" style="color: white; text-decoration: none;">WOMEN</a></li>
                    <li><a href="index.php#kids" style="color: white; text-decoration: none;">STORE</a></li>
                    <li><a href="contact.html" style="color: white; text-decoration: none;">CONTACTUS</a></li>
                 </ul>
             </nav>
              <div style="display: flex; gap: 15px; align-items: center;">
                 <i style="color: white;font-size: 19.5px;" class="fas fa-search"></i>
                 <?php 
                    $cart_item_count = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $item) {
                            if(isset($item['quantity']) && is_numeric($item['quantity'])){
                                $cart_item_count += $item['quantity'];
                            }
                        }
                    }
                 ?>
                 <a href="cart.php" style="color: white; font-size: 24px; text-decoration: none; position: relative;">🛒<?php if ($cart_item_count > 0): ?><span style="position: absolute; top: -10px; right: -10px; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; line-height: 1;"><?php echo $cart_item_count; ?></span><?php endif; ?></a>
                 
                  <?php // Check login status ?>
                 <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <span style="color: white;">Hi, <?php echo htmlspecialchars($_SESSION["user_first_name"]); ?>!</span>
                    <a href="logout.php" style=" color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;border: 1px solid white;">Logout</a>
                     <?php if ($_SESSION["user_type"] == 'admin'): ?>
                         <a href="admin/index.php" style=" color: yellow; padding: 8px 15px; border-radius: 5px; text-decoration: none;border: 1px solid yellow;">Admin</a>
                    <?php endif; ?>
                 <?php else: ?>
                     <a href="signin.php" style=" color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;border: 1px solid white;">Sign In</a>
                 <?php endif; ?>
             </div>
         </div>
     </header>

    <!-- Main Content -->
    <div style="padding-top: 100px;">
        <div class="container">
            <div class="form-container">
                <h2>Sign In</h2>
                <p>Please fill in your credentials to login.</p>

                <?php 
                if (!empty($errors['login'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($errors['login']) . '</div>';
                }
                if (!empty($errors['db_error'])) {
                     echo '<div class="alert alert-danger">' . htmlspecialchars($errors['db_error']) . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Email or Phone Number</label>
                        <input type="text" name="login_identifier" class="form-control <?php echo (!empty($errors['login_identifier'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($login_identifier); ?>">
                         <?php if (!empty($errors['login_identifier'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['login_identifier']) . '</span>'; ?>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($errors['password'])) ? 'is-invalid' : ''; ?>">
                        <?php if (!empty($errors['password'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['password']) . '</span>'; ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                    <p class="auth-link">Don't have an account? <a href="signup.php">Sign up now</a>.</p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="margin-top: 50px;">
         <div class="container">
             <div class="row">
                  <!-- Footer Content Copied -->
                 <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo"><img src="assets/images/white-logo.png" alt="..."></div>
                        <ul><li><a href="#">ABOUT US</a></li><li><a href="#">Lorem ipsum...</a></li></ul>
                    </div>
                </div>
                <div class="col-lg-3"><h4>ALL MEnu</h4><ul><li><a href="index.php">Home</a></li><li><a href="#">Shop</a></li>...</ul></div>
                <div class="col-lg-3"><h4>CATEGORIES</h4><ul><li><a href="#">Clothes</a></li>...</ul></div>
                <div class="col-lg-3"><h4>ACCOUNT</h4><ul><li><a href="signin.php">Sign in / Sign up</a></li>...</ul></div>
                <div class="col-lg-12"><div class="under-footer"><ul><li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>...</ul></div></div>
             </div>
         </div>
     </footer>

    <!-- Scripts -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html> 