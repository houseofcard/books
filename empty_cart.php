<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);

//create the user_id for SQL method
$cart_item->user_id=$_SESSION['user_id'];

if($cart_item->deleteAllByUser()){
	// redirect to product list and tell the user it was removed from cart
	header("Location: {$home_url}cart.php?action=empty_success");
}

else{
	header("Location: {$home_url}cart.php?action=empty_failed");
}
?>
