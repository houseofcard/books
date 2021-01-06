<?php
// core configuration
include_once 'config/core.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
//include_once "libs/php/utils.php";
include_once 'objects/product.php';
include_once "objects/product_image.php"; // added so can view image in cart
include_once 'objects/category.php';
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// initialize utility class
//$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);  // added so can view image in cart
$category = new Category($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// set page title
$page_title="My Cart";

// include page header html
include_once 'layout_head.php';

// parameters
$action = isset($_GET['action']) ? $_GET['action'] : "";

// display a message
// if a product was added to cart
if($action=='added'){
	echo "<p>Product was added to your cart!</p>";
}

// unable to add product to cart
else if($action=='failed_add'){
	echo "<p>Product was not added to cart.</p>";
}

// product removed from cart
else if($action=='removed'){
	echo "<p>Product was removed from your cart!</p>";
}

// product quantity updated
else if($action=='quantity_updated'){
	echo "<p>Product quantity was updated!</p>";
}
	
// product quantity update failed
else if($action=='quantity_update_failed'){
	echo "<p>Failed to update product quantity. Please contact us.</p>";
}
	
// empty cart
else if($action=='empty_success'){
	echo "<p>Cart was emptied!</p>";
}

// empty cart failed
else if($action=='empty_failed'){
	echo "<p>Unable to empty cart.</p>";
}

//create the user_id for SQL method
$cart_item->user_id=$_SESSION['user_id'];

$stmt = $cart_item->readAll_WithoutPaging();

// count number of rows returned
$num=$stmt->rowCount();

if($num>0){
	
	// remove all cart contents
	echo "<div>";
		echo "<button class='btn btn-primary pull-right' id='empty-cart'>";
		echo "<i class='glyphicon glyphicon-shopping-cart'></i> Empty cart";
		echo "</button>";
	echo "</div>";
		
	// display cart items
    $total=0;
	$item_count=0;
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
		
		echo "<hr class='line'>";
		echo "<h3>";
			echo "<a href='{$home_url}product.php?id={$row['id']}'>";
			echo "{$name}";
			echo "</a> ";
		echo "</h3>";
		echo "<p>Size: ";	
		echo "{$variation_name}</p>";
				
		echo "<div class= 'column-cart'>";		
			
			// added so can view image in cart
			$id=$row['id'];
			$rowImage=$product->readOne();
			$product_image->product_id=$id;
			$stmt_product_image = $product_image->readAll();
			while ($rowImage = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
				$product_image_name = $rowImage['name'];
				$source="{$home_url}uploads/images/{$product_image_name}";
				echo "<img src='{$source}'>";
			}
				
			// read variation
			$variation->id=$variation_id;
			$variation->readOne();
						
		echo "</div>";
		
		echo "<div class= 'column-cart'>";
			echo "<p>Unit Price: &#36;" . number_format($price, 2, '.', ',') . "</p>";
			echo "<p>Only {$variation->stock} left in stock</p>";		
			$item_count += $quantity;
			$total += $subtotal;
	
			// update quantity
			
			echo "<form class='update-quantity-form'>";
				echo "<div class='product-id'>{$id}</div>";
				echo "<p>Quantity:  ";
				echo "<select class='variation cart-quantity' style='font-size:14px'>";
				for($x=1; $x<=$variation->stock; $x++){
					if($x==$quantity){
						echo "<option selected>{$x}</option>";
					}
					else{
						echo "<option>{$x}</option>";
					}
				}
				
				echo "</select>";
				echo"&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo "<button class='btn btn-primary update-quantity' type='submit'>Update</button>";
				echo "</p>";
			echo "</form>";

			// delete from cart
			echo "<a href='remove_from_cart.php?id={$id}&name={$name}' class='btn btn-primary delete-button'>";
				echo "Remove item";
			echo "</a></button>";
		
			
		echo "</div>";
		echo "<div class= 'column-cart'>";
			echo "<div class= 'column-totals'>";
				$quantity_str=$quantity>1 ? "items" : "item";
				echo "<p style = 'text-align:left'><b>{$quantity} {$quantity_str} @	&#36;" . number_format($price, 2, '.', ',') . "</b></p>";
			echo "</div>";
			echo "<div class= 'column-totals'>";
				echo "<p style = 'text-align:right'><b>Subtotal: </b>";
				echo "<b>&#36;" . number_format($subtotal, 2, '.', ',') . "</b></p>";
			echo "</div>";
			echo "<div class='clear'></div>";
		echo "</div>";	
		echo "<div class='clear'></div>";
	}
	
	// bottom line across page
	echo "<div class= 'column-cart'></div>";
	echo "<hr class='line'>";
	echo "<div class='clear'></div>";	
	
	// total sum in third column
	echo "<div class='column-cart'></div>";
		echo "<div class='column-cart'></div>";
			echo "<div class='column-cart'>";
				echo "<div class='column-totals'>";
					echo "<p style = 'text-align:left'><b>Total ({$item_count} items) </b></p>";
				echo "</div>";	
				echo "<div class='column-totals'>";
					echo "<p style = 'text-align:right'><b>&#36;" . number_format($total, 2, '.', ',') . "</b></p>";
				echo "</div>";	
				echo "<div class='clear'></div>";	
			echo "</div>";
			echo "<div class='clear'></div>";	
	
	
	// proceed to checkout
	echo "<a href='{$home_url}checkout.php' class='btn btn-primary pull-right'>";
	echo "<span class='glyphicon glyphicon-shopping-cart'></span>Proceed to Checkout";
	echo "</a>";
}else{
	echo "<p>No products found in your cart!</p>";
}

// footer HTML and JavaScript codes
include 'layout_foot.php';
?>