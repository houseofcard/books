<?php
// core configuration
include_once "config/core.php";

// include classes
//include_once "libs/php/utils.php";
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/category.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// initialize utility class
//$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$category = new Category($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// count all products
$products_count=$product->countAll();

// set page title
$page_title="Products";

// include page header HTML
include_once 'layout_head.php';

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// used when something was added to cart
$id = isset($_GET['id']) ? $_GET['id'] : "";

echo "<div>";

	// if login was successful
	if($action=='login_success'){
		echo "<p>Hi " . $_SESSION['firstname'] . ". Welcome back!</p>";
	}

	// if user was not admin
	else if($action=='not_admin'){
		echo "<p>You cannot access that page.</p>";
	}

	// if login was successful
	else if($action=='already_logged_in'){
		echo "<p>You are already logged in.</p>";
	}

	// if product is inactive
	else if($action=='product_inactive'){
		echo "<p>The product you are trying to view is inactive.</p>";
	}

echo "</div>";

// read all active products in the database
$stmt=$product->readAll($from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// if products retrieved were more than zero
if($num>0){

	// display the list of products
	include_once "read_products_template.php";
}

// tell the user if there's no products in the database
else{
	echo "<p>No products found.</p>";
}

// footer HTML and JavaScript codes
include 'layout_foot.php';
?>
