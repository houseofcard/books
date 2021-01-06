<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
//include_once 'libs/php/utils.php';
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// initialize utility class
//$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);
$variation = new Variation($db);

// product details
$id = isset($_GET['id']) ?  $_GET['id'] : die('ID not found.');
$quantity  = isset($_GET['quantity']) ?  $_GET['quantity'] : 1;
$variation_id  = isset($_GET['variation_id']) ?  $_GET['variation_id'] : die('Variation ID not found.');
$created = date('Y-m-d H:i:s');

// validate quantity
$quantity=$quantity>0 ? $quantity : 1;

// get product price and variation name
$variation->id=$variation_id;
$variation->readOne();

// bind values
$cart_item->product_id=$id;
$cart_item->quantity=$quantity;
$cart_item->variation_id=$variation_id;
$cart_item->variation_name=$variation->name;
$cart_item->price=$variation->price;
$cart_item->user_id=$_SESSION['user_id'];
$cart_item->created=$created;

// if database insert succeeded
if($cart_item->create()){
   header('Location: cart.php?action=added');
}

// if database insert failed
else{
   header('Location: cart.php?action=failed_add');
}

?>
