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
	<?php include_once 'navigation.php'; ?>
			
	<!-- container -->
	<div class="container">
	
	<div class = "searchBox">
		<form role="search" action='search.php'>
			<!-- maintain search term in the text box -->
			<input type="text" placeholder="Type product name..." size="15" name="s" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> /> 
			<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</form>
	</div>
	<div class='clear'></div>

<div class="additionalmenu">
	<?php 
	// read all product categories
	$stmt=$category->readAll_WithoutPaging();
	$num = $stmt->rowCount();

	//loop through retrieved categories
	if($num>0){
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			echo "<div class='categories'>";
				echo "<a href='{$home_url}category.php?id={$row['id']}'>{$row['name']}</a>";
			echo "</div>";
		}
	}
	echo "<div class='clear'></div>";
	echo "</div>";
//echo "<figure'><img src='images/title.jpg' alt='Image of Books' Width='800' Height='150' id='pageImage'></figure>";
?>
	<div>
		<h1><?php echo isset($page_title) ? $page_title : "Books Galore"; ?></h1>
	</div>	