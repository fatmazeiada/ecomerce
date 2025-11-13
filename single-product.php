<?php 
require_once 'config.php';

// Initialize variables
$product = null;
$error_message = '';
$product_id = null;

// Check if product ID is set and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT id, name, description, image, price, stock, category_id FROM products WHERE id = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $product_id);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Get result
            $result = $stmt->get_result();
            
            // Check if product exists
            if ($result->num_rows == 1) {
                // Fetch result row as an associative array
                $product = $result->fetch_assoc();
            } else {
                $error_message = "Product not found.";
            }
        } else {
            // In production, log this error instead of echoing
            $error_message = "Oops! Something went wrong. Please try again later.";
            error_log("SQL Execute Error: " . $stmt->error);
        }
        // Close statement
        $stmt->close();
    } else {
         // In production, log this error
         $error_message = "Oops! Something went wrong. Please try again later.";
         error_log("SQL Prepare Error: " . $mysqli->error);
    }
} else {
    $error_message = "Invalid product ID specified.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Hexashop - Product Detail</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header style="background-color: black; position: fixed; width: 100%; top: 0; left: 0; z-index: 1000; padding: 10px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <img src="assets/images/white-logo.png" style="height: 50px;">
            </a>
            <!-- Menu -->
            <nav>
                <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
                    <li><a href="index.php#home" style="color: white; text-decoration: none;">BESTCOLLECTION</a></li>
                    <li><a href="index.php#men" style="color: white; text-decoration: none;">MEN</a></li>
                    <li><a href="index.php#women" style="color: white; text-decoration: none;">WOMEN</a></li>
                    <li><a href="index.php#kids" style="color: white; text-decoration: none;">STORE</a></li>
                    <li><a href="contact.html" style="color: white; text-decoration: none;">CONTACTUS</a></li>
                </ul>
            </nav>
            <!-- Icons -->
            <div style="display: flex; gap: 15px; align-items: center;">
                <i style="color: white;font-size: 19.5px;" class="fas fa-search"></i>
                 <?php 
                    // Calculate cart item count (same logic as index.php)
                    $cart_item_count = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $item) {
                            if(isset($item['quantity']) && is_numeric($item['quantity'])){
                                $cart_item_count += $item['quantity'];
                            }
                        }
                    }
                ?>
                <a href="cart.php" style="color: white; font-size: 24px; text-decoration: none; position: relative;">
                    🛒
                    <?php if ($cart_item_count > 0): ?>
                        <span style="position: absolute; top: -10px; right: -10px; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; line-height: 1;">
                            <?php echo $cart_item_count; ?>
                        </span>
                    <?php endif; ?>
                </a>
                
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
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <!-- Simple placeholder for spacing, adjust as needed -->
    <div style="padding-top: 100px; padding-bottom: 20px; background-color: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h4>Product Details</h4>
                        <span>Details of the selected product</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Product Area Starts ***** -->
    <section class="section" id="product">
        <div class="container">
            <?php if ($product): ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        <?php 
                          $image_path = 'assets/images/' . ($product['image'] ?? 'default-product.jpg'); // Default image if none set
                        ?>
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 100%; height: auto; border: 1px solid #eee;">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                        <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                        
                        <!-- Placeholder for reviews/stars if you add them later -->
                        <!-- <ul class="stars"> -->
                        <!--    <li><i class="fa fa-star"></i></li> -->
                        <!--    ... -->
                        <!-- </ul> -->
                        
                        <span><?php echo nl2br(htmlspecialchars($product['description'] ?? 'No description available.')); ?></span>
                        
                        <!-- Add quantity selection and Add to Cart button using a form -->
                        <form action="add_to_cart.php" method="post" style="margin-top: 20px;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            
                            <div class="quantity-content">
                                <div class="left-content">
                                    <h6>Quantity:</h6>
                                </div>
                                <div class="right-content">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="<?php echo $product['stock'] > 0 ? $product['stock'] : '1'; ?>" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                                        <input type="button" value="+" class="plus">
                                    </div>
                                </div>
                            </div>
                            <div class="total" style="margin-top: 20px;">
                                <div class="main-border-button">
                                    <button type="submit" class="btn" style="/* Add styles similar to .main-border-button a */ background-color: #2a2a2a; color: #fff; border: none; padding: 10px 20px; cursor: pointer;" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>Add To Cart</button>
                                </div>
                                 <?php 
                                    // Prepare stock display message
                                    $stock_display = '';
                                    if ($product['stock'] > 0) {
                                        $stock_display = htmlspecialchars($product['stock']);
                                    } else {
                                        $stock_display = '<span style="color: red;">Out of Stock</span>';
                                    }
                                 ?>
                                 <p style="margin-top: 10px;">Stock: <?php echo $stock_display; ?></p>
                            </div>
                        </form>
                        <!-- End Form -->
                        
                    </div>
                </div>
            </div>
            <?php elseif ($error_message): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                    <p class="text-center"><a href="index.php">Return to Homepage</a></p>
                </div>
            </div>
            <?php else: ?>
             <div class="row">
                <div class="col-lg-12">
                     <div class="alert alert-warning text-center" role="alert">
                        Loading product details...
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- ***** Product Area Ends ***** -->

    <!-- Display Flash Message -->
    <?php 
    if (isset($_SESSION['flash_message'])):
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']); // Clear the message after displaying
        $alert_class = ($flash['status'] == 'success') ? 'alert-success' : 'alert-danger';
    ?>
    <div class="container" style="margin-top: 80px;"> <!-- Adjust margin as needed -->
         <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($flash['message']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="assets/images/white-logo.png" alt="hexashop ecommerce templatemo">
                        </div>
                        <ul>
                            <li><a href="#">ِِِِABOUT US</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod nemo, in ipsum delectus asperiores iste!</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>ALL MEnu</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li> <!-- Updated Link -->
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Category</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="contact.html">Contact us</a></li> <!-- Updated Link -->
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>CATEGORIES</h4>
                    <ul>
                        <li><a href="#">Clothes</a></li>
                        <li><a href="#">Shoes</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Watch</a></li>
                        <li><a href="#">Sungalass</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>ACCOUNT</h4>
                    <ul>
                        <li><a href="signin.html">Sign in / Sign up</a></li> <!-- Updated Link -->
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Checkout</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <ul>
                            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

     <style>
        /* Basic styles for quantity buttons - you might have these in your main CSS */
        .quantity input {
            width: 50px;
            text-align: center;
            border: 1px solid #eee;
            padding: 5px;
        }
        .quantity input[type="button"] {
            cursor: pointer;
            border: 1px solid #eee;
            padding: 5px 10px;
            background-color: #f8f9fa;
        }
        .quantity input[type="button"]:hover {
            background-color: #e2e6ea;
        }
        .buttons_added {
            display: inline-block;
        }
        .main-border-button a {
            /* Ensure this matches your template's button style */
            display: inline-block;
            padding: 10px 20px;
            background-color: #2a2a2a; /* Example color */
            color: #fff;
            border: none;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        .main-border-button a:hover {
             background-color: #000; /* Example hover color */
        }
        .under-footer ul {
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 0;
        }

        .under-footer ul li {
            display: inline-block;
        }

        .under-footer ul li a {
            text-decoration: none;
            font-size: 24px;
            color: #fff; 
            transition: color 0.3s ease;
        }

        .under-footer ul li a:hover {
            color: rgb(57, 46, 46); 
        }

    </style>

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/isotope.js"></script>

    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    
    <!-- Basic Quantity JS (Add to custom.js or here) -->
    <script>
        jQuery(document).ready(function($){
            // Quantity buttons
            function wcqib_refresh_quantity_increments() {
                $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');
            }

            $(document).on('updated_wc_div', function () {
                wcqib_refresh_quantity_increments();
            });

            $(document).on('click', '.plus, .minus', function () {
                // Get values
                var $qty = $(this).closest('.quantity').find('.qty');
                var currentVal = parseFloat($qty.val());
                var max = parseFloat($qty.attr('max'));
                var min = parseFloat($qty.attr('min'));
                var step = $qty.attr('step');

                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                // Change the value
                if ($(this).is('.plus')) {
                    if (max && (currentVal >= max)) {
                        $qty.val(max);
                    } else {
                        $qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
                    }
                } else {
                    if (min && (currentVal <= min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
                    }
                }

                // Trigger change event
                $qty.trigger('change');
            });
            
            // Helper function for decimals
            String.prototype.getDecimals || (String.prototype.getDecimals = function () {
                var a = this, b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                return b ? b[1] ? b[1].length : 0 : 0
            });
            
             wcqib_refresh_quantity_increments();
        });
    </script>

</body>
</html>
<?php
// Close the database connection
$mysqli->close();
?> 