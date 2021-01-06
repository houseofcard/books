<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once "config/database.php";

// include objects and classes
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

// get category id from url
$category_id=isset($_GET['id']) ? $_GET['id'] : die('no category id found');

// read category name
$category->id=$category_id;
$category->readOne();
$category_name=$category->name;

// count products under the category
$product->category_id=$category_id;
$products_count=$product->countAll_ByCategory();

// set page title
$page_title=$category_name . " <br><small>{$products_count} Products</small>";

// set page header HTML
include_once 'layout_head.php';

// read all products under a category
$product->category_id=$category_id;
$stmt=$product->readAllByCategory($from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// if there are products under a category, display them
if($num>0){
	
	// to identify page for paging
	$page_url="category.php?id={$category_id}&";
	
	// show products
	include_once "read_products_template.php";
}

// tell the user if there's no products under that category
else{
	echo "<p>No products found in this category.</p>";
}

// footer HTML and JavaScript codes
include_once 'layout_foot.php';
?>
