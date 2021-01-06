<?php
// connect to database
include_once '../config/database.php';
	
// include objects and classes
include_once '../objects/product_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product_image = new ProductImage($db);
	
// get ID of the image to be deleted
$image_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
	
// delete the product image
$product_image->id = $image_id;
if($product_image->delete()){
		
	header('Location: read_products.php?action=image_deleted');
}

// if unable to delete the product image
else{
	echo "<p>Unable to delete object.</p>";
}

?>