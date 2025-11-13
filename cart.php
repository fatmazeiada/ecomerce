<?php 
require_once 'config.php'; // Includes session_start()

$cart_items = $_SESSION['cart'] ?? [];
$total_amount = 0;

// Calculate total amount
foreach ($cart_items as $item) {
    if (isset($item['price']) && isset($item['quantity'])) {
        $total_amount += $item['price'] * $item['quantity'];
    }
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

    <title>Hexashop - Shopping Cart</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    
    <style>
        /* Basic Cart Table Styling */
        .cart-table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        .cart-table th,
        .cart-table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .cart-table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .cart-table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        .cart-total {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 5px;
        }
         .product-name-link a {
             color: #333;
             text-decoration: none;
         }
         .product-name-link a:hover {
             color: #007bff; /* Or your theme's link hover color */
             text-decoration: underline;
         }
    </style>

</head>

<body>

    <!-- ***** Preloader Start (Optional) ***** -->
    <!-- <div id="preloader">...</div> -->

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
                    // Calculate cart item count
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
    <div style="padding-top: 100px; padding-bottom: 20px; background-color: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h4>Shopping Cart</h4>
                        <span>Review items in your cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Cart Area Starts ***** -->
    <section class="section" id="cart-details">
        <div class="container">
             <!-- Display Flash Message -->
            <?php 
            if (isset($_SESSION['flash_message'])):
                $flash = $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); // Clear message
                $alert_class = ($flash['status'] == 'success') ? 'alert-success' : 'alert-danger';
            ?>
            <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash['message']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>

            <?php if (!empty($cart_items)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th> <!-- Placeholder for remove button -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item_id => $item): ?>
                                <?php 
                                    $subtotal = (isset($item['price']) && isset($item['quantity'])) ? ($item['price'] * $item['quantity']) : 0;
                                    $product_link = 'single-product.php?id=' . $item_id;
                                ?>
                                <tr>
                                    <td class="product-name-link">
                                        <a href="<?php echo htmlspecialchars($product_link); ?>">
                                            <?php echo htmlspecialchars($item['name'] ?? 'N/A'); ?>
                                        </a>
                                    </td>
                                    <td>$<?php echo number_format($item['price'] ?? 0, 2); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity'] ?? 0); ?></td> 
                                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <!-- Add remove button later -->
                                        <button class="btn btn-sm btn-danger" disabled>Remove</button> 
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-total">
                        Total: $<?php echo number_format($total_amount, 2); ?>
                    </div>
                    <div style="text-align: right; margin-top: 20px;">
                         <!-- Add checkout button later -->
                        <a href="#" class="btn btn-success" style="padding: 10px 20px;">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="empty-cart">
                        <h4>Your cart is currently empty.</h4>
                        <p><a href="index.php">Continue Shopping</a></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- ***** Cart Area Ends ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
       <!-- Footer content copied from single-product.php -->
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Category</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="contact.html">Contact us</a></li>
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
                        <li><a href="signin.html">Sign in / Sign up</a></li>
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

    <!-- Scripts -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
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
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php
// Optional: Close DB connection if it wasn't closed in add_to_cart.php logic 
// (Though in this case, cart.php doesn't need DB connection after initial session load)
// $mysqli->close(); 
?> 