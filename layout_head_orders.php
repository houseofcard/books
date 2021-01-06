<?php
// initialize if session cart is empty
if(!isset($_SESSION['cart'])){
	$_SESSION['cart']=array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
   	
	<!-- set the page title -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>
	
</head>
<body>

	<!-- include the navigation bar -->
	<?php include_once 'navigation_orders.php'; ?>
			
	<!-- container -->
	<div class="container">
	
	<div class = "searchBoxOrders">
		<form role="search" action='search.php'>
			<!-- maintain search term in the text box -->
			<input type="text" placeholder="Type product name..." size="15" name="s" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> /> 
			<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</form>
	</div>
	<div class='clear'></div>
	
	<div>
		<h1><?php echo isset($page_title) ? $page_title : "Books Galore"; ?></h1>
	</div>
		
	
		