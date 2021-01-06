<?php
if($page_title!="Order Search Results"){
	echo "<ul class='nav nav-tabs'>";
		echo $status=="Pending Reconciliation" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
			echo "<a href='{$home_url}admin/read_orders.php'>Pending Reconciliation</a>";
		echo "</li>";
		echo $status=="Payment Reconciled" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
			echo "<a href='{$home_url}admin/read_orders.php?status=Payment Reconciled'>Payment Reconciled</a>";
		echo "</li>";
		echo $status=="Completed" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
			echo "<a href='{$home_url}admin/read_orders.php?status=Completed'>Items Sent / Order Completed</a>";
		echo "</li>";
		echo $status=="Order Cancelled" ? "<li role='presentation' class='active'>" : "<li role='presentation'>";
			echo "<a href='{$home_url}admin/read_orders.php?status=Order Cancelled'>Order Cancelled</a>";
		echo "</li>";
	echo "</ul>";
}

?>
<!-- search order function -->
<div>
	<div class="searchBox">
		<form role="search" action='search_orders.php'>
			<input type="text" placeholder="Type transaction ID..." size="15" name="s" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
			<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</form>
	</div>
	<div class="clear"></div>
</div>
<?php
// display the table if number of orders retrieved is greater than zero
if($num>0){
		
	echo "<div class='table-responsive'>";
		echo "<table class='table table-hover table-bordered'>";
		
			// table headers
			echo "<tr>";
				echo "<th class='textAlignLeft'>Transaction ID</th>";
				echo "<th>Transaction Date</th>";
				echo "<th>Customer Name</th>";
				echo "<th>Total Cost</th>";
				echo "<th>Status</th>";
				echo "<th>Action</th>";
			echo "</tr>";

			// loop through the order records
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				// display order details
				echo "<tr>";
					echo "<td>{$transaction_id}</td>";
					echo "<td>{$created}</td>";
					echo "<td>{$firstname} {$lastname}</td>";
					echo "<td>&#36;" . number_format($total_cost, 2, '.', ',') . "</td>";
					echo "<td>{$status}</td>";
					echo "<td>";

						// view details button
						echo "<a href='read_one_order.php?transaction_id={$transaction_id}' class='btn btn-primary'>";
							echo "<span class='glyphicon glyphicon-list'></span> View Details";
						echo "</a>";
					echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	echo "</div>";
		
	// pagination, identify $page_dom and $total_rows
	// the page where pagination was used
	$page_dom="";

	// the number of rows retrieved on that page
	$total_rows=0;

	// order search results
	if($page_title=='Order Search Results'){
		$page_dom = "search_orders.php?s={$search_term}&";
		$total_rows = $order->countAll_BySearch($search_term);
	}

	// all orders
	else if($page_title=='Orders'){
		$page_dom = "read_orders.php?status={$status}&";
		$total_rows = $order->countAll();
	}

	// actual paging buttons
	include_once 'paging.php';
}

// tell the user there were no orders in the database
else{
	echo "<br>";
	echo "<p>No orders found</p>";
}
?>
