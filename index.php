<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Hexashop Ecommerce HTML CSS Template</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">
<!--

TemplateMo 571 Hexashop

https://templatemo.com/tm-571-hexashop

-->


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
     <!-- الهيدر -->
     <header style="background-color: black; position: fixed; width: 100%; top: 0; left: 0; z-index: 1000; padding: 10px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <!-- اللوجو -->
            <a href="index.php" class="logo">
                <img src="assets/images/white-logo.png" style="height: 50px;">
            </a>

            <!-- القائمة -->
            <nav>
                <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
                    <li><a href="index.php#home" style="color: white; text-decoration: none;">BESTCOLLECTION</a></li>
                    <li><a href="index.php#men" style="color: white; text-decoration: none;">MEN</a></li>
                    <li><a href="index.php#women" style="color: white; text-decoration: none;">WOMEN</a></li>
                    <li><a href="index.php#kids" style="color: white; text-decoration: none;">STORE</a></li>
                    <li><a href="contact.html" style="color: white; text-decoration: none;">CONTACTUS</a></li>
                </ul>
            </nav>

            <!-- الأيقونات -->
            <div style="display: flex; gap: 15px; align-items: center;">
                <i style="color: white;font-size: 19.5px;" class="fas fa-search"></i>
                <?php 
                    // Calculate cart item count
                    $cart_item_count = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        // If storing quantity directly:
                        // $cart_item_count = count($_SESSION['cart']); // Counts unique products
                        // If you want total number of items (sum of quantities):
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
                    <?php if ($_SESSION["user_type"] == 'admin'): // Link to admin dashboard if admin ?>
                         <a href="admin/index.php" style=" color: yellow; padding: 8px 15px; border-radius: 5px; text-decoration: none;border: 1px solid yellow;">Admin</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="signin.php" style=" color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;border: 1px solid white;">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div>
        <img style="width: 100%;" src="assets/images/1.jpg" alt="">
    </div>
   

    <div class="image-container">
        <div class="image-wrapper">
            <span class="image-text">WOMEN</span>
            <img src="assets/images/27.jpg" alt="">
        </div>
        <div class="image-wrapper">
            <span class="image-text">MEN</span>
            <img src="assets/images/26.jpg" alt="">
        </div>
    </div>
    
    <Style>
        .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    width: 80%;
    margin: 100px auto; /* يجعلها في المنتصف مع مسافة من الأعلى والأسفل */
}

.image-wrapper {
    position: relative;
    width: 40%;
}

.image-wrapper img {
    width: 100%;
    height: 450px;
    display: block;
}

.image-text {
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translate(-30%,-20%);
    color: black;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 25px;
    font-weight: bold;
    text-align: center;
}

    </Style>

    <!-- ***** Men Area Starts ***** -->
    <section  class="section" id="men" style="background-color: rgba(128, 128, 128, 0.384);">
        <div class="container" >
            <div class="row" >
                <div class="col-lg-12 " >
                    <div style="display: flex; justify-content: space-between;" class="section-heading">
                        <h2>BEST SELLER</h2>

                        <button style="border: none;background-color: red;padding: 0 18px;color: white;">show All</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" >
            <div class="row">
                <div class="col-lg-12" >
                    <div class="men-item-carousel" >
                        <div class="owl-men-item owl-carousel">
                            <?php
                                // Fetch products from the database for Men category (ID=1)
                                // Added JOIN to get category name if needed later, though not used in display yet
                                $sql_men = "SELECT p.id, p.name, p.price, p.image 
                                            FROM products p 
                                            JOIN categories c ON p.category_id = c.id 
                                            WHERE p.category_id = 1 LIMIT 8"; // Category ID 1 = Men
                                $products_men = []; // Renamed variable for clarity
                                if($result_men = $mysqli->query($sql_men)){
                                    if($result_men->num_rows > 0){
                                        while($row_men = $result_men->fetch_assoc()){
                                            $products_men[] = $row_men;
                                        }
                                        $result_men->free();
                                    } else{
                                        echo '<p class="text-center">No Men products found.</p>'; // Updated message
                                    }
                                } else{
                                    echo "ERROR: Could not able to execute $sql_men. " . $mysqli->error;
                                }

                                // Loop through men products and display them
                                foreach ($products_men as $product) { // Use the correct variable
                                    $image_path = 'assets/images/' . ($product['image'] ?? 'default.jpg');
                                    $formatted_price = '$' . number_format($product['price'], 2);
                                    $sales_placeholder = rand(10, 99) . ' sales';
                                    $product_link = 'single-product.php?id=' . $product['id'];
                            ?>
                            <div class="item">
                                <div class="thumb" style="background-color: rgba(128, 128, 128, 0.384);">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-star"></i></a></li>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img style="height: 370px; width: 100%; object-fit: cover;" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </div>
                                <div class="down-content" style="background-color: rgba(128, 128, 128, 0.384);">
                                    <span style="text-align: center;color: black;"><?php echo $sales_placeholder; ?></span>
                                    <h4 style="text-align: center;"><?php echo htmlspecialchars(strtoupper($product['name'])); ?></h4>
                                    <span style="text-align: center;color: black;"><?php echo $formatted_price; ?></span>
                                </div>
                            </div>
                            <?php
                                } // End foreach loop
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Men Area Ends ***** -->

    <!-- ***** Women Area Starts ***** -->
    <section class="section" id="women">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 " >
                    <div style="display: flex; justify-content: space-between;" class="section-heading">
                        <h2>NEW COLLECTION</h2>

                        <button style="border: none;background-color: red;padding: 0 18px;color: white;">show All</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="women-item-carousel">
                        <div class="owl-women-item owl-carousel">
                            <?php
                                // Fetch products for Women category (ID=2)
                                $sql_women = "SELECT p.id, p.name, p.price, p.image 
                                              FROM products p 
                                              JOIN categories c ON p.category_id = c.id 
                                              WHERE p.category_id = 2 LIMIT 8"; // Category ID 2 = Women
                                $products_women = [];
                                if($result_women = $mysqli->query($sql_women)){
                                    if($result_women->num_rows > 0){
                                        while($row_women = $result_women->fetch_assoc()){
                                            $products_women[] = $row_women;
                                        }
                                        $result_women->free();
                                    } else{
                                        echo '<p class="text-center">No Women products found for this collection.</p>'; // Updated message
                                    }
                                } else{
                                    echo "ERROR: Could not execute $sql_women. " . $mysqli->error;
                                }

                                foreach ($products_women as $product) {
                                    $image_path = 'assets/images/' . ($product['image'] ?? 'default.jpg');
                                    $formatted_price = '$' . number_format($product['price'], 2);
                                    $sales_placeholder = rand(10, 99) . ' sales';
                                    $product_link = 'single-product.php?id=' . $product['id'];
                            ?>
                            <div class="item">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-star"></i></a></li>
                                            <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <img style="height: 370px; width: 100%; object-fit: cover;" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </div>
                                <div class="down-content" >
                                    <span style="text-align: center;color: black;"><?php echo $sales_placeholder; ?></span>
                                    <h4 style="text-align: center;"><?php echo htmlspecialchars(strtoupper($product['name'])); ?></h4>
                                    <span style="text-align: center;color: black;"><?php echo $formatted_price; ?></span>
                                </div>
                            </div>
                             <?php
                                } // End foreach loop
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Women Area Ends ***** -->



 <!-- ***** Best Seller Area 2 Starts ***** -->
    <section class="section" id="women_best_seller"> <!-- Changed ID slightly to avoid conflict if needed -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 " >
                    <div >
                        <h2 style="text-align: center;">BEST SELLER</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="women-item-carousel"> <!-- Assuming same class works -->
                        <div class="owl-women-item owl-carousel"> <!-- Assuming same class works -->
                             <?php
                                // Fetch products for second BEST SELLER (e.g., next 8)
                                $sql_bs2 = "SELECT id, name, price, image FROM products LIMIT 8 OFFSET 16"; // Example: fetch different products
                                $products_bs2 = [];
                                if($result_bs2 = $mysqli->query($sql_bs2)){
                                    if($result_bs2->num_rows > 0){
                                        while($row_bs2 = $result_bs2->fetch_assoc()){
                                            $products_bs2[] = $row_bs2;
                                        }
                                        $result_bs2->free();
                                    } else{
                                        echo '<p class="text-center">No best sellers found currently.</p>';
                                    }
                                } else{
                                    echo "ERROR: Could not execute $sql_bs2. " . $mysqli->error;
                                }

                                foreach ($products_bs2 as $product) {
                                    $image_path = 'assets/images/' . ($product['image'] ?? 'default.jpg');
                                    $formatted_price = '$' . number_format($product['price'], 2);
                                    // Using price as placeholder below image as in original static design
                                    $product_link = 'single-product.php?id=' . $product['id'];
                            ?>
                            <div class="item">
                                <div class="thumb">
                                    <div class="hover-content">
                                        <ul>
                                             <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-eye"></i></a></li>
                                             <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-star"></i></a></li>
                                             <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                     <img style="height: 370px; width: 100%; object-fit: cover;" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </div>
                                <div class="down-content" >
                                    <span style="text-align: center;color: black;"><?php echo $formatted_price; ?></span>
                                    <h4 style="text-align: center;"><?php echo htmlspecialchars(strtoupper($product['name'])); ?></h4>
                                    <span style="text-align: center;color: black;"><?php echo $formatted_price; ?></span>
                                </div>
                            </div>
                             <?php
                                } // End foreach loop
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Best Seller Area 2 Ends ***** -->



<!-- ***** Other Product Area 1 Starts ***** -->
<section class="section" id="other_products_1"> <!-- Changed ID -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 " >
                    <h2 >SHOW OTHER PRODUCT</h2>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px;" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="women-item-carousel"> <!-- Assuming same class -->
                    <div class="owl-women-item owl-carousel"> <!-- Assuming same class -->
                         <?php
                            // Fetch products for OTHER PRODUCT 1 (e.g., next 4)
                            $sql_op1 = "SELECT id, name, price, image FROM products LIMIT 4 OFFSET 24"; // Example: fetch different products
                            $products_op1 = [];
                            if($result_op1 = $mysqli->query($sql_op1)){
                                if($result_op1->num_rows > 0){
                                    while($row_op1 = $result_op1->fetch_assoc()){
                                        $products_op1[] = $row_op1;
                                    }
                                    $result_op1->free();
                                } else{
                                    echo '<p class="text-center">No other products found.</p>';
                                }
                            } else{
                                echo "ERROR: Could not execute $sql_op1. " . $mysqli->error;
                            }

                            foreach ($products_op1 as $product) {
                                $image_path = 'assets/images/' . ($product['image'] ?? 'default.jpg');
                                $product_link = 'single-product.php?id=' . $product['id'];
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="hover-content">
                                    <ul>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-star"></i></a></li>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <img style="height: 340px; width: 100%; object-fit: cover;" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <!-- No down-content needed for this specific design section -->
                        </div>
                        <?php
                            } // End foreach loop
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Other Product Area 1 Ends ***** -->


<!-- ***** Other Product Area 2 Starts ***** -->
<section class="section" id="other_products_2"> <!-- Changed ID -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 " >
                    <h2 style="text-align: center;">SHOW OTHER PRODUCT</h2>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 10px;" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="women-item-carousel"> <!-- Assuming same class -->
                    <div class="owl-women-item owl-carousel"> <!-- Assuming same class -->
                        <?php
                            // Fetch products for OTHER PRODUCT 2 (e.g., next 4)
                            $sql_op2 = "SELECT id, name, price, image FROM products LIMIT 4 OFFSET 28"; // Example: fetch different products
                            $products_op2 = [];
                            if($result_op2 = $mysqli->query($sql_op2)){
                                if($result_op2->num_rows > 0){
                                    while($row_op2 = $result_op2->fetch_assoc()){
                                        $products_op2[] = $row_op2;
                                    }
                                    $result_op2->free();
                                } else{
                                    echo '<p class="text-center">No other products to show.</p>';
                                }
                            } else{
                                echo "ERROR: Could not execute $sql_op2. " . $mysqli->error;
                            }

                            foreach ($products_op2 as $product) {
                                $image_path = 'assets/images/' . ($product['image'] ?? 'default.jpg');
                                $formatted_price = '$' . number_format($product['price'], 2);
                                $product_link = 'single-product.php?id=' . $product['id'];
                                // Placeholder for ratings as it's not in DB
                                $rating_placeholder = '
                                    <span style="color: red;">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i> <!-- Example: 3/5 stars -->
                                        <i class="far fa-star"></i>
                                        (Review Placeholder)
                                    </span>';
                        ?>
                        <div class="item">
                            <div class="thumb">
                                <div class="hover-content">
                                    <ul>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-star"></i></a></li>
                                        <li><a href="<?php echo htmlspecialchars($product_link); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <img  style="height: 370px; width: 100%; object-fit: cover;" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="down-content" >
                                <span style="text-align: center;color: black;"><?php echo htmlspecialchars(strtoupper($product['name'])); ?></span>
                                <h4 style="text-align: center; font-size: 0.9em; margin-top: 5px; margin-bottom: 5px;"> <!-- Adjusted styling slightly for rating -->
                                   <?php echo $rating_placeholder; ?>
                                </h4>
                                <span style="text-align: center;color: black;"><?php echo $formatted_price; ?></span>
                            </div>
                        </div>
                        <?php
                            } // End foreach loop
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Other Product Area 2 Ends ***** -->


<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card" style="width: 18rem;">
                <img style="height: 200px;" class="card-img-top" src="assets/images/35.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Shoes Masterpiece chunky</h5>
                  <p class="card-text">Aliquam iacus erat eget efficitur eu .cursus eu nisle.</p>
                  <a href="#" class="">READ MORE</a>
                  <p class="card-text">By Admin  |  comments.</p>

                </div>
              </div>
        </div>

        <div class="col-lg-4">
            <div class="card" style="width: 18rem;">
                <img style="height: 200px;" class="card-img-top" src="assets/images/36.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">TOMMY JEANS RYAN 3.5 BELT</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the  .</p>
                  <a href="#" class="">READ MORE</a>
                  <p class="card-text">By Admin  |  comments.</p>

                </div>
              </div>
        </div>

        <div class="col-lg-4">
            <div class="card" style="width: 18rem;">
                <img style="height: 200px;" class="card-img-top" src="assets/images/37.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Hairband Burgundy</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the .</p>
                  <a href="#" class="">READ MORE</a>
                  <p class="card-text">By Admin  |  comments.</p>

                </div>
              </div>
        </div>
    </div>
</div>
    

    <!-- ***** Social Area Starts ***** -->
    <section class="section" id="social">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 style="text-align: center;">Follow us on</h2>
                        <h2 style="text-align: center;font-size: 16px;">instgram</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row images">
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>Fashion</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/21.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>New</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/20.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>Brand</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/19.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>Makeup</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/18.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>Leather</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/17.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
                <div class="col-2">
                    <div class="thumb">
                        <div class="icon">
                            <a href="http://instagram.com">
                                <h6>Bag</h6>
                                <i class="fa fa-instagram"></i>
                            </a>
                        </div>
                        <img src="assets/images/16.jpg" alt="" style="height: 220px;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Social Area Ends ***** -->


    
  
    
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
                            <li><a href="#about">ABOUT US</a></li>
                            <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod nemo, in ipsum delectus asperiores iste!</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>ALL MENU</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php">Shop</a></li>
                        <li><a href="index.php">Category</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="contact.html">Contact us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>CATEGORIES</h4>
                    <ul>
                        <li><a href="index.php#women">Women</a></li>
                        <li><a href="index.php#men">Men</a></li>
                        <li><a href="index.php#kids">Kids</a></li>
                        <li><a href="index.php">Accessories</a></li>
                        <li><a href="index.php">Cosmetics</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>ACCOUNT</h4>
                    <ul>
                        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                             <li><a href="#">My Account</a></li>
                            <?php if ($_SESSION["user_type"] == 'admin'): ?>
                                <li><a href="admin/index.php">Admin Dashboard</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="signin.php">Sign in / Sign up</a></li>
                        <?php endif; ?>
                         <li><a href="cart.php">Shopping Cart</a></li> 
                         <li><a href="#">Track Order</a></li>
                         <li><a href="cart.php">Checkout</a></li>
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
    color: #fff; /* غيّر اللون حسب تصميمك */
    transition: color 0.3s ease;
}

.under-footer ul li a:hover {
    color: rgb(57, 46, 46); /* لون عند التمرير */
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

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

  </body>
</html>
<?php
// Close database connection
$mysqli->close();
?>