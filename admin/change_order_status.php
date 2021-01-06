<?php
// check if value was posted
if($_POST){
	
	// connect to database
	include_once '../config/database.php';
	
	// include objects and classes
	include_once '../objects/order.php';

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	// initialize objects
	$order = new Order($db);
	
	// set posted values
	$order->transaction_id=isset($_POST['transaction_id']) ? $_POST['transaction_id'] : "";
	$order->status=isset($_POST['status']) ? $_POST['status'] : "";
	
	// change order status
	if($order->changeStatus()){
		echo "<p>Status was changed.</p>";
	}
	
	// if unable to change order status
	else{
		echo "<p>Unable to change status.</p>";
	}
}
?>