<?php 
require_once 'config.php';

$first_name = $last_name = $phone = $email = $password = $confirm_password = $address = "";
$errors = [];
$success_message = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    if (empty(trim($_POST["first_name"]))) {
        $errors['first_name'] = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty(trim($_POST["last_name"]))) {
        $errors['last_name'] = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $errors['phone'] = "Please enter your phone number.";
    } else {
        $phone = trim($_POST["phone"]);
        // Check if phone number already exists
        $sql_check_phone = "SELECT id FROM users WHERE phone = ?";
        if ($stmt_check = $mysqli->prepare($sql_check_phone)) {
            $stmt_check->bind_param("s", $phone);
            $stmt_check->execute();
            $stmt_check->store_result();
            if ($stmt_check->num_rows > 0) {
                $errors['phone'] = "This phone number is already registered.";
            }
            $stmt_check->close();
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Please enter your email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
        // Check if email already exists
        $sql_check_email = "SELECT id FROM users WHERE email = ?";
        if ($stmt_check = $mysqli->prepare($sql_check_email)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();
            if ($stmt_check->num_rows > 0) {
                $errors['email'] = "This email address is already registered.";
            }
            $stmt_check->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $errors['password'] = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $errors['confirm_password'] = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($errors['password']) && ($password != $confirm_password)) {
            $errors['confirm_password'] = "Password did not match.";
        }
    }
    
    // Validate address (optional)
    $address = trim($_POST["address"]);

    // Check input errors before inserting in database
    if (empty($errors)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (first_name, last_name, phone, email, password, address, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'customer', NOW(), NOW())";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_fname, $param_lname, $param_phone, $param_email, $param_password, $param_address);

            // Set parameters
            $param_fname = $first_name;
            $param_lname = $last_name;
            $param_phone = $phone;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_address = $address;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page or show success message
                 $success_message = "Registration successful! You can now <a href='signin.php'>sign in</a>.";
                 // Clear form fields after successful registration
                 $_POST = array(); // Clear POST array
                 $first_name = $last_name = $phone = $email = $password = $confirm_password = $address = "";
                // header("location: signin.php"); 
                // exit;
            } else {
                $errors['db_error'] = "Something went wrong. Please try again later.";
                error_log("Signup Execute Error: " . $stmt->error);
            }

            // Close statement
            $stmt->close();
        } else {
             $errors['db_error'] = "Database error preparing statement.";
             error_log("Signup Prepare Error: " . $mysqli->error);
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
    <title>Hexashop - Sign Up</title>
    <!-- Add CSS files similar to other pages -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
     <style>
        .form-container { 
            max-width: 600px; 
            margin: 50px auto; 
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #fff;
         }
         .form-group {
            margin-bottom: 1rem;
         }
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
                <h2>Sign Up</h2>
                <p>Please fill this form to create an account.</p>
                
                <?php 
                if (!empty($success_message)) {
                    echo '<div class="alert alert-success">' . $success_message . '</div>';
                }
                if (!empty($errors['db_error'])) {
                     echo '<div class="alert alert-danger">' . htmlspecialchars($errors['db_error']) . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($errors['first_name'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($first_name); ?>">
                            <?php if (!empty($errors['first_name'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['first_name']) . '</span>'; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control <?php echo (!empty($errors['last_name'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($last_name); ?>">
                            <?php if (!empty($errors['last_name'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['last_name']) . '</span>'; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control <?php echo (!empty($errors['phone'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($phone); ?>">
                        <?php if (!empty($errors['phone'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['phone']) . '</span>'; ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($errors['email'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                         <?php if (!empty($errors['email'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['email']) . '</span>'; ?>
                    </div>
                    <div class="row">
                         <div class="col-md-6 form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($errors['password'])) ? 'is-invalid' : ''; ?>" value="">
                            <?php if (!empty($errors['password'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['password']) . '</span>'; ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($errors['confirm_password'])) ? 'is-invalid' : ''; ?>" value="">
                            <?php if (!empty($errors['confirm_password'])) echo '<span class="invalid-feedback">' . htmlspecialchars($errors['confirm_password']) . '</span>'; ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label>Address (Optional)</label>
                        <textarea name="address" class="form-control"><?php echo htmlspecialchars($address); ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>
                    <p class="auth-link">Already have an account? <a href="signin.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php // Include footer or copy paste it here ?>
    <footer style="margin-top: 50px;">
       <div class="container">
            <div class="row">
                </div>
                 <!-- Footer Content Copied From index.php -->
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
    <!-- Include other JS if needed -->
    <script src="assets/js/custom.js"></script>

</body>
</html> 