<?php
// core configuration
include_once "config/core.php";

// include login checker
//include_once "login_checker.php";

// connect to database
include_once "config/database.php";

// include objects and classes
include_once "objects/product.php";
include_once "objects/category.php";
include_once "objects/user.php";
include_once "objects/order.php";
include_once "objects/order_item.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$category = new Category($db);
$user = new User($db);
$order = new Order($db);
$order_item = new OrderItem($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// set page title
$page_title="Contact Us";

// include page header HTML
include_once 'layout_head.php';

// contact details
echo "<p>BooksGalore Limited can be contacted via email at BooksGalore@gmail.com</p>";

// footer HTML and JavaScript codes
include_once 'layout_foot.php';
?>
