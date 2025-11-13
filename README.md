# Hexashop E-commerce Project Documentation

## 1. Overview

This project is a basic e-commerce web application built with PHP and MySQL. It includes a frontend for customers to browse products and manage their cart, and an admin panel for managing products, categories, users, and orders.

## 2. Features

### Frontend:
*   Display products by category (Men, Women, etc.) on the homepage.
*   View single product details (`single-product.php`).
*   User registration (`signup.php`) and login (`signin.php`).
*   Add products to a shopping cart (session-based).
*   View and manage the shopping cart (`cart.php`).
*   User logout (`logout.php`).
*   (Basic structure for other sections like About, Contact).

### Admin Panel (`/admin/`):
*   Secure login for admin users only.
*   Dashboard overview (`admin/index.php`).
*   **Product Management:** View, Add, Edit, Delete products (including image uploads).
*   **Category Management:** View, Add, Edit, Delete categories.
*   **User Management:** View users, Add new users (admin/customer), Edit user type (admin/customer), Delete users.
*   **Order Management:** View list of orders, View order details (customer info, items), Update order status.
*   Responsive layout (adjusts for smaller screens).

## 3. Technology Stack

*   **Backend:** PHP (procedural/mixed style)
*   **Database:** MySQL / MariaDB
*   **Frontend:** HTML, CSS, JavaScript (including jQuery and basic Bootstrap for admin styling)
*   **Web Server:** Apache (as part of XAMPP) or similar PHP-compatible server.

## 4. Setup Instructions

Follow these steps to set up the project on your local machine or a new server.

### Prerequisites:
*   A web server environment (like XAMPP, WAMP, MAMP, or a standard LAMP/LEMP stack) with:
    *   PHP (version 7.4 or higher recommended)
    *   MySQL or MariaDB database server
    *   Apache or Nginx web server

### Step 1: Database Setup
1.  **Create Database:** Using a tool like phpMyAdmin or the MySQL command line, create a new database. Let's assume you name it `ecommerce_db`.
2.  **Import SQL:** Import the provided `ecommerce.sql` file into your newly created database (`ecommerce_db`). This will create the necessary tables (`users`, `products`, `categories`, `orders`, `order_items`).
3.  **Admin User:** The SQL file might contain a default admin user. If not, you can:
    *   Register a new user through the frontend `signup.php`.
    *   Manually change the `user_type` field for that user in the `users` table from 'customer' to 'admin' using phpMyAdmin or an SQL UPDATE query.

### Step 2: File Placement
1.  **Copy Files:** Copy all the project files and folders (`admin`, `assets`, `index.php`, `config.php`, etc.) into the appropriate directory for your web server.
    *   For XAMPP/WAMP: Usually `C:/xampp/htdocs/` or `C:/wamp/www/`. You can place the project files directly in `htdocs` or create a subfolder (e.g., `htdocs/hexashop/`). Access URL would be `http://localhost/` or `http://localhost/hexashop/`.
    *   For Linux LAMP: Often `/var/www/html/`.

### Step 3: Configuration
1.  **Edit `config.php`:** Open the `config.php` file located in the project's root directory.
2.  **Update Database Credentials:** Modify the following lines with your actual database connection details:
    ```php
    define('DB_SERVER', 'localhost'); // Keep as 'localhost' if DB is on the same server
    define('DB_USERNAME', 'YOUR_DB_USERNAME'); // Replace with your MySQL username (e.g., 'root')
    define('DB_PASSWORD', 'YOUR_DB_PASSWORD'); // Replace with your MySQL password (often empty for default XAMPP root)
    define('DB_NAME', 'ecommerce_db'); // Replace with the name you chose in Step 1
    ```
3.  **Session Path (Optional):** Usually, PHP handles sessions correctly. However, if you encounter session-related errors, ensure the `session.save_path` in your `php.ini` configuration is valid and writable by the web server. `config.php` starts the session (`session_start()`).

### Step 4: Permissions (Especially for Linux/macOS)
1.  **Image Uploads:** Ensure the web server has write permissions for the image upload directory: `assets/images/`. You might need to run a command like `sudo chmod -R 775 assets/images` and potentially `sudo chown -R www-data:www-data assets/images` (replace `www-data` with your web server's user/group if different). **Note:** `777` is generally discouraged in production; use the minimum permissions required.

### Step 5: Access the Site
*   **Frontend:** Open your web browser and navigate to the project URL (e.g., `http://localhost/` or `http://localhost/your_project_folder/`).
*   **Admin Panel:** Navigate to the admin directory (e.g., `http://localhost/admin/` or `http://localhost/your_project_folder/admin/`). Log in using the admin account credentials you set up.

## 5. Usage Guide

### Admin Panel:
*   **Login:** Access `/admin/` and log in with an 'admin' type user.
*   **Dashboard:** Provides quick links to manage Orders and Users.
*   **Products:** List, Add, Edit (including changing image), and Delete products.
*   **Categories:** List, Add, Edit, and Delete categories. Deleting a category used by products is prevented.
*   **Users:** List, Add (customer or admin), Edit user type (cannot edit own type), Delete users (cannot delete own account).
*   **Orders:** List all orders. Click "View Details" to see order specifics (items, customer info, addresses if available) and update the order status.

### Frontend:
*   **Browsing:** Explore products on the homepage sections.
*   **Product Details:** Click on a product image or link to go to `single-product.php` (assuming this page exists and displays details).
*   **Cart:** Use "Add to Cart" buttons (implementation likely on `single-product.php` or via JS sending data to `add_to_cart.php`). View cart contents at `cart.php`.
*   **Login/Signup:** Use the "Sign In" / "Sign up" links. Logged-in users see a welcome message and logout button. Admins see an additional "Admin" link.

## 6. File Structure Overview

```
htdocs/
├── admin/                  # Admin Panel Files
│   ├── partials/           # Header and Footer for Admin Panel
│   │   ├── header.php
│   │   └── footer.php
│   ├── add_category.php
│   ├── add_product.php
│   ├── add_user.php
│   ├── auth_check.php      # Checks for admin login status
│   ├── categories.php
│   ├── delete_category.php
│   ├── delete_product.php
│   ├── delete_user.php
│   ├── edit_category.php
│   ├── edit_product.php
│   ├── edit_user.php
│   ├── index.php           # Admin Dashboard
│   ├── orders.php
│   ├── products.php
│   ├── users.php
│   └── view_order.php
├── assets/                 # Frontend CSS, JS, Images, Fonts
│   ├── css/
│   ├── fonts/
│   ├── images/             # Product images uploaded here
│   └── js/
├── add_to_cart.php         # Script to handle adding items to cart (likely via POST/AJAX)
├── cart.php                # Shopping Cart page
├── config.php              # Database connection, session start, main config
├── ecommerce.sql           # Database schema and initial data
├── index.php               # Frontend Homepage
├── logout.php              # User logout script
├── signin.php              # User login page
├── signup.php              # User registration page
└── single-product.php      # Frontend single product view page
```

## 7. Deployment / Moving Servers

To move the project to a different server (e.g., from local XAMPP to a live hosting environment):

1.  **Database:**
    *   **Export:** Export your current database (e.g., from phpMyAdmin on your local machine) as an SQL file.
    *   **Import:** Import this SQL file into the new database on the target server.
2.  **Files:**
    *   **Transfer:** Copy *all* project files and folders to the public web directory on the new server (e.g., `public_html`, `htdocs`, `/var/www/html`).
3.  **Configuration:**
    *   **Update `config.php`:** Edit the `config.php` on the *new server* with the new database credentials (server, username, password, database name) provided by your hosting provider.
4.  **Permissions:**
    *   **Check `assets/images/`:** Ensure the `assets/images/` directory has the correct write permissions for the web server user on the new server to allow image uploads. Permissions required might vary depending on the server setup.
5.  **Paths:**
    *   The code uses `__DIR__` in several places (like `config.php`, image upload paths), which helps make paths relative to the current file's location. This should generally work when moving servers, but double-check if you encounter issues with file includes or image paths.
6.  **PHP Version & Settings:**
    *   Ensure the new server's PHP version is compatible (ideally 7.4+).
    *   Check relevant PHP settings in `php.ini` on the new server if needed (e.g., `upload_max_filesize`, `post_max_size` for image uploads, error reporting levels).

## 8. Potential Improvements / Future Work

*   **Pagination:** Add pagination to admin tables (Products, Users, Orders, Categories) for better handling of large datasets.
*   **Search & Filtering:** Implement search and filtering functionality in admin tables and possibly on the frontend shop page.
*   **Frontend Shop Page:** Create a dedicated shop page that lists all products with filtering and sorting options.
*   **Checkout Process:** Implement a proper checkout process (`checkout.php`) after the cart, collecting shipping/billing info and saving the order details correctly.
*   **Payment Gateway Integration:** Integrate a payment gateway (Stripe, PayPal, etc.).
*   **Security Enhancements:**
    *   Implement CSRF (Cross-Site Request Forgery) protection on all forms.
    *   Enhance XSS (Cross-Site Scripting) prevention (continue using `htmlspecialchars` diligently).
    *   Add more robust input validation.
*   **JavaScript Enhancements:**
    *   Use AJAX for smoother "Add to Cart" functionality without page reloads.
    *   Implement the admin sidebar toggle functionality using JavaScript.
*   **Error Handling & Logging:** Implement more user-friendly error messages and robust server-side logging instead of echoing database errors directly.
*   **Password Reset:** Add a "Forgot Password" feature.
*   **Refactoring/OOP:** Consider refactoring the code using Object-Oriented Programming (OOP) principles and potentially a simple routing mechanism or micro-framework for better organization as the project grows.
*   **Frontend Design:** Separate Header and Footer into include files (`partials/header.php`, `partials/footer.php`) for the frontend, similar to the admin panel, to avoid code duplication.

---

This documentation provides a comprehensive guide to setting up, using, and understanding the Hexashop project. Remember to keep backups of your database and files, especially before making major changes or moving servers. 