<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once "config/database.php";

// include objects and classes
include_once "objects/product.php";
include_once "objects/product_image.php"; // added so can view image in cart
include_once "objects/category.php";
include_once "objects/user.php";
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);  // added so can view image in cart
$category = new Category($db);
$user = new User($db);
$cart_item = new CartItem($db);

// set page title
$page_title="Checkout";

// include page header HTML
include_once 'layout_head.php';

//create the user_id for SQL method	
$cart_item->user_id=$_SESSION['user_id'];

$stmt = $cart_item->readAll_WithoutPaging();
	
// count number of rows returned
$num=$stmt->rowCount();
	
if($num>0){

	// display cart items
    $total=0;
	$item_count=0;

	// used for paypal checkout
	$items=array();

	while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

		echo "<hr class='line'>";
		echo "<h4>{$name}";
		echo "</h4>";
		echo "<p>Size: ";	
			echo "{$variation_name}";
		echo "</p>";
			
			echo "<div class= 'column'>";		
			
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
			echo "</div>";
			
			echo "<div class= 'column'>";
				$quantity_str=$quantity>1 ? "items" : "item";
				echo "<p style = 'text-align:center'>{$quantity} {$quantity_str} @ &#36;" . number_format($price, 2, '.', ',') . "</p>";
			echo "</div>";

			echo "<div class= 'column'>";
				echo "<div class= 'column-totals'>";
				echo "<p><b>Subtotal: </b></p>";
				echo "</div>";
				echo "<div class= 'column-totals'>";
				echo "<p style = 'text-align:right'><b>&#36;" . number_format($subtotal, 2, '.', ',') . "</b></p>";
				echo "</div>";
				echo "<div class='clear'></div>";	
			echo "</div>";
		echo "<div class='clear'></div>";
			
					
		$item_count += $quantity;
		$total += $subtotal;
	}

	// bottom line across page
	echo "<hr class='line'>";
		
	// total sum in third column
	echo "<div class= 'column'></div>";
	echo "<div class= 'column'></div>";
	echo "<div class= 'column'>";
		echo "<div class= 'column-totals'>";
		echo "<p><b>Total ({$item_count} items)</b></p>";
		echo "</div>";
		echo "<div class= 'column-totals'>";
		echo "<p style = 'text-align:right'><b>&#36;" . number_format($total, 2, '.', ',') . "</b></p>";
		echo "</div>";
		echo "<div class='clear'></div>";
	echo "</div>";	
	echo "<div class='clear'></div>";	
	
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){

		echo "<h2>Your Personal Information</h2>";
		
		// read user information / details
		$user->id=$_SESSION['user_id'];
		$user->readOne();
		
		echo "<div>";
			// use the information as billing information
			echo "<h3>Billing Information</h3>";
			echo "<p>Name:  ";
			echo "{$user->firstname} {$user->lastname}</p>";
			echo "<p>Address:  ";
			echo "{$user->address}</p>";
			echo "<p>Contact Number:  ";
			echo "{$user->contact_number}</p>";
			echo "<br>";

			// give user the ability to update billing information
			echo "<a href='edit_profile.php' class='btn btn-info'>";
			echo "Edit Billing Information";
			echo "</a>";
			echo "<br>";
	echo "</div>";
	
	echo "<br>";
	echo "<div>";
			// payment information
			echo "<h3>Payment Method</h3>";
			echo "<p>Payment can be made by bank transer into the following account:</p>";
			echo "<p>Account Name:  BooksGalore Limited</p>";
			echo "<p>Account Number:  06 0942 005 125678 00</p>";
			echo "<p>Please include your username within the bank transfer details</p>";
			echo "<p>Items will be dispatched once payment is received by Looney Limited</p>";	
			echo "</div>";
			echo "<br>";
			
			echo "<div>";
			
				// button to place order
			echo "<a href='place_order.php' class='btn btn-primary pull-right'>";
						echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
					echo "</a>";
			
		}
		
		// if the user was not logged in yet, tell him he cannot checkout without logging in
		else{
			echo "<p>Please log in to place order.</p>";
			echo "<p>Already have an account? <a href='{$home_url}login.php'>Log In</a></p>";
			echo "<p>If you do not have an account then register as a user before logging in.<a href='{$home_url}register.php'>Register</a></p>";
		}
	}

	// tell the user there are no products in the cart
	else{
		echo "<p>No products found in your cart!</p>";
	}


// include page footer HTML
include_once 'layout_foot.php';
?>
