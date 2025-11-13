<?php
require_once 'config.php'; // Includes session_start()

$product_id = null;
$quantity = null;
$response = [
    'status' => 'error',
    'message' => 'Invalid request.',
    'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0
];

// Check if product ID and quantity are provided via POST
if (isset($_POST['product_id']) && is_numeric($_POST['product_id']) && isset($_POST['quantity']) && is_numeric($_POST['quantity'])) {
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        $response['message'] = 'Quantity must be positive.';
    } else {
        // Fetch product details (price and stock) to validate
        $sql = "SELECT price, stock, name FROM products WHERE id = ?";
        $product_data = null;
        $error = false;

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $product_id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $product_data = $result->fetch_assoc();
                } else {
                    $response['message'] = 'Product not found.';
                    $error = true;
                }
            } else {
                $response['message'] = 'Error fetching product data.';
                error_log("Cart Add Execute Error: " . $stmt->error);
                $error = true;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Database error preparing statement.';
            error_log("Cart Add Prepare Error: " . $mysqli->error);
            $error = true;
        }
        
        $mysqli->close(); // Close connection early if possible

        // Proceed only if no errors and product data fetched
        if (!$error && $product_data) {
            // Check stock
            $current_stock = $product_data['stock'];
            $current_cart_quantity = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id]['quantity'] : 0;
            
            if (($current_cart_quantity + $quantity) > $current_stock) {
                 $response['message'] = 'Cannot add quantity. Not enough stock available. Available: ' . $current_stock;
            } else {
                // Initialize cart if it doesn't exist
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // Check if product is already in cart
                if (isset($_SESSION['cart'][$product_id])) {
                    // Update quantity
                    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                } else {
                    // Add new item to cart
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'name' => $product_data['name'], // Store name for easy display in cart
                        'price' => $product_data['price'], // Store price
                        'quantity' => $quantity
                        // Store image later if needed for cart page
                    ];
                }
                
                $response['status'] = 'success';
                $response['message'] = 'Product added to cart!';
                // Calculate new cart count
                $response['cart_count'] = count($_SESSION['cart']); 
            }
        }
        // else: $response['message'] already set by validation steps
    }
} else {
     $response['message'] = 'Missing product ID or quantity.';
}

// Return JSON response (useful if using AJAX later, but works for direct POST too)
// Redirect back to product page or cart page after adding
// Getting the referer page
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // Default to index if referer isn't set

// Add status message to session flash data (optional but good UX)
$_SESSION['flash_message'] = [
    'status' => $response['status'],
    'message' => $response['message']
];

header("Location: " . $referer);
exit;

?> 