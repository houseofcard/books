<?php

// connect to database
include_once '../config/database.php';
	
// include objects and classes
include_once '../objects/product.php';
include_once '../objects/product_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);

// get ID of the product to be edited
$product_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// delete the product
$product->id = $product_id;

if($product->delete()){
	
	// delete all related images in database & directory
	$product_image->product_id=$product_id;
	$product_image->deleteAll();
	
	header('Location: read_products.php?action=product_deleted');

	// if unable to delete the product
}else{
	echo "<p>Unable to delete object.</p>";
}
?>