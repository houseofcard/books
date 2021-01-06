<?php
// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);

// get ID of the category to be deleted
$category_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// delete the category
$category->id = $category_id;

if($category->delete()){
		
	header('Location: read_categories.php?action=category_deleted');
}
// if unable to delete the category
else{
	echo "<br>";
	echo "<p>Unable to delete object.</p>";
}
?>