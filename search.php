<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once "config/database.php";

// include objects
//include_once "libs/php/utils.php";
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

// set page title
$page_title="Product Search Results";

// include page header HTML
include_once 'layout_head.php';

// search keywords
$search_term=isset($_GET['s']) ? $_GET['s'] : "";

// to prevent xss
$search_term=htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8');

// search the database
$stmt = $product->search($search_term, $from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// if count was greater than zero
if($num>0){
	// display the retrieved products
	include_once "read_products_template.php";
}

// tell the user if there's no products in the database
else{
	echo "<strong>No products found.</strong>";
}

// footer HTML and JavaScript codes
include_once 'layout_foot.php';
?>
