<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/category.php';
include_once '../objects/user.php';
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);
$user = new User($db);
$order = new Order($db);

// set page title
$page_title = "User Search Results";

// include page header HTML
include_once "layout_head.php";

// create search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';

// search users based on search term
$stmt = $user->search($search_term, $from_record_num, $records_per_page);

// count retrieved users
$num = $stmt->rowCount();

// to identify page for paging
$page_url="search_users.php?s={$search_term}&";

// include users table HTML template
include_once "read_users_template.php";

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
