<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../libs/php/utils.php';
include_once "../objects/category.php";
include_once "../objects/product.php";
include_once "../objects/variation.php";
include_once "../objects/order.php";

// initialize utilities class
$utils = new Utils();

// get databae connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);
$product = new Product($db);
$variation = new Variation($db);
$order = new Order($db);

// get ID of the product
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die('ERROR: missing product ID.');

// set ID property of product
$product->id = $product_id;

// read the details of product
$product->readOne();

// set page title
$page_title = "<small>Variations of </small><br />{$product->name}";

// import page header HTML
include_once "layout_head.php";

// count pending orders
$pending_orders_count=$order->countPending();

// create product button
echo "<div class='createLink'>";
echo "<a href='read_products.php' class='btn btn-primary pull-right'>";
    echo "<span class='glyphicon glyphicon-list'></span> Read Products";
echo "</a>";

echo "<a href='create_variation.php?product_id={$product_id}' class='btn btn-primary pull-right m-r-15px'>";
	echo "<span class='glyphicon glyphicon-plus'></span> Create Variation";
echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";
 
// list variations
$variation->product_id=$product_id;
$stmt=$variation->readByProductId();

// count number of products returned
$num = $stmt->rowCount();

// if number of products returned is more than 0
if($num>0){
   
	echo "<div class='table-responsive'>";
		echo "<table class='table table-hover table-bordered'>";

			echo "<tr>";
				echo "<th width='25%'>Name</th>";
				echo "<th width='25%'>Price</th>";
				echo "<th width='25%'>Stock</th>";
				echo "<th width='25%'>Action</th>";
			echo "</tr>";

			// list products from the database
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);

				echo "<tr>";
					echo "<td>{$name}</td>";
					echo "<td>&#36;" . number_format($price, 2) . "</td>";
					echo "<td>{$stock}</td>";
					echo "<td>";
                    // edit variation button
						echo "<a href='update_variation.php?id={$id}&product_id={$product_id}' class='btn btn-info m-r-15px'>";
							echo "<span class='glyphicon glyphicon-edit'></span> Edit";
						echo "</a>";

						// delete variation button
						echo "<a delete-id='{$id}' file='variation' class='btn btn-danger delete-object'>";
							echo "<span class='glyphicon glyphicon-remove'></span> Delete";
						echo "</a>";
					echo "</td>";
				echo "</tr>";
			}

		echo "</table>";
	echo "</div>";
}else{
	echo "<p>No variations found.</p>";
}

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
