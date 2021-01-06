<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once "../config/database.php";

// include objects and classes
include_once "../objects/category.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);

// set page title
$page_title = "Categories";

// include page header HTML
include_once "layout_head.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

// read all categories in the database
$stmt = $category->readAll($from_record_num, $records_per_page);

// count number of categories returned
$num = $stmt->rowCount();

// to identify page for paging
$page_url="read_categories.php?";

// include categories table HTML template
include_once "read_categories_template.php";

// include page footer HTML
include_once 'layout_foot.php';
?>
