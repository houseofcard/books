<?php
// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// get ID of the user to be deleted
$user_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// delete the user
$user->id = $user_id;

if($user->delete()){
   	  
	header('Location: read_users.php?action=user_deleted');
}

// if unable to delete the user
else{
	echo "<br>";
    echo "<p>Unable to delete object.</p>";
}
?>