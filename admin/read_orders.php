<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/order.php';
include_once "../objects/category.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);
$category = new Category($db);

// set page title
$page_title = "Orders";

// include page header HTML
include_once "layout_head.php";

// get order status
$status=isset($_GET['status']) ? $_GET['status'] : "Pending Reconciliation";
$order->status=$status;

// read all orders in the database
$stmt = $order->readAll($from_record_num, $records_per_page);

// count number of orders returned
$num = $stmt->rowCount();

//to identify page for paging
$page_url="read_orders.php?status={$status}&";

// include orders table HTML template
include_once "read_orders_template.php";

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
