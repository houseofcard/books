<?php
// core configuration
include_once "config/core.php";

// include login checker
include_once "login_checker.php";

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once "objects/category.php";
include_once 'objects/user.php';
include_once "objects/order.php";
include_once "objects/order_item.php";
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);
$user = new User($db);
$order = new Order($db);
$order_item = new OrderItem($db);
$cart_item = new CartItem($db);

// set page title
$page_title = "Order Details";

// include page header HTML
include_once "layout_head_orders.php";

echo "<div>";

	// read user record base on given id
	$transaction_id=isset($_GET['transaction_id']) ? $_GET['transaction_id'] : "";
	$order->transaction_id=$transaction_id;
	$order->readOneByTransactionId();

	// check if record exists
	if($order->created){

	// read order details
	?>
	
	<!-- create product button -->
	<div class="viewOrders">
		<a href='orders.php' class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Back to Orders
		</a>
	</div>
	<div class="clear"></div>

	<!-- display order summary / details -->
	<h3><b>Order Summary</b></h3>

	<table class='table table-hover table-responsive table-bordered'>

		<tr>
			<td><b>Transaction ID</b></td>
			<td><?php echo $transaction_id; ?></td>
		</tr>
		<tr>
			<td><b>Transaction Date</b></td>
			<td><?php echo $order->created; ?></td>
		</tr>
		<tr>
			<td><b>Total Cost</b></td>
			<td>&#36;<?php echo number_format($order->total_cost, 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td><b>Payment Method</b></td>
			<td><?php echo $order->from_paypal=="1" ? "PayPal" : "Bank Transfer"; ?></td>
		</tr>
		<tr>
			<td><b>Status</b></td>
			<td><?php echo $order->status; ?></td>
		</tr>
	</table>

	<br>
	
	<h3><b>Order Items</b></h3>
	<?php

	// retrieve order items
	$order_item->transaction_id=$transaction_id;
	$stmt=$order_item->readAll();

	echo "<table class='table table-hover table-responsive table-bordered'>";

		// our table heading
		echo "<tr>";
			echo "<td class='textAlignLeft'><b>Product Name</b></td>";
			echo "<td><b>Price (NZD)</b></td>";
			echo "<td><b>Quantity</b></td>";
			echo "<td><b>Subtotal</b></td>";
		echo "</tr>";

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			// read product details

			//creating new table row per record
			echo "<tr>";
				echo "<td>{$product_name} ({$variation_name})</td>";
				echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
				echo "<td>{$quantity}</td>";
				echo "<td>&#36;";
					echo number_format($price*$quantity, 2, '.', ',');
				echo "</td>";
			echo "</tr>";

		}

		// display total cost
		echo "<tr>";
			echo "<td><b>Total Cost</b></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td><b>&#36;" . number_format($order->total_cost, 2, '.', ',') . "</b></td>";
		echo "</tr>";

	echo "</table>";

	}

	// tell the user order does not exist
	else{
		echo "<p>Order does not exist.</p>";
	}

echo "</div>";

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>