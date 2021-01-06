<?php
// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/variation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$variation = new Variation($db);

// get ID of the variation to be deleted
$variation_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// delete the variation
$variation->id = $variation_id;
if($variation->delete()){

	header('Location: read_products.php?action=variation_deleted');
}

// if unable to delete the variation
else{
	echo "<p>Unable to delete object.</p>";
}
?>
