<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/user.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$order = new Order($db);

// set page title
$page_title = "Users";

// include page header HTML
include_once "layout_head.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

// read all users in the database
$stmt = $user->readAll($from_record_num, $records_per_page);

// count number of users returned
$num = $stmt->rowCount();

// to identify page for paging
$page_url="read_users.php?";

// include users table HTML template
include_once 'read_users_template.php';

// footer HTML and JavaScript codes
include_once 'layout_foot.php';
?>
