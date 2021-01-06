<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once "config/database.php";

// include objects and classes
//include_once "libs/php/utils.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/category.php";
include_once 'objects/cart_item.php';
include_once 'objects/variation.php';

// initialize utility class
//$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$category = new Category($db);
$cart_item = new CartItem($db);
$variation = new Variation($db);

// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// set the id as product id property
$product->id = $id;

// check if product is active
if(!$product->isActive()){
	// redirect
	header("Location: {$home_url}products.php?action=product_inactive");
}

// to read single record product
$row = $product->readOne();

//set page title
$page_title = $product->name;

// include page header HTML
include_once 'layout_head.php';

// set product id
$product_image->product_id=$id;

// read all related product image
$stmt_product_image = $product_image->readAll();

// count all related product image
$num_product_image = $stmt_product_image->rowCount();


echo "<div class='column-product'>";
	// read all related product image
	$stmt_product_image = $product_image->readAll();
	$num_product_image = $stmt_product_image->rowCount();

	// if count is more than zero
	if($num_product_image>0){
		
		// loop through all product images
		$x=0;
		while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
			// image name and source url
			$product_image_name = $row['name'];
			$source="{$home_url}uploads/images/{$product_image_name}";
			$show_product_img=$x==0 ? "display-block" : "display-none";
			echo "<a href='{$source}'>";
			echo "<img src='{$source}' Width='200' Height='300'>";
			echo "</a>";
			$x++;
		}
	}else{ echo "No images."; }
echo "</div>";

echo "<div class='column-product'>";
	$variation->product_id=$id;
	$variation->readFirstByProductId();
	
	echo "<h4>Author:</h4>";
	echo "<div>";
		$author = htmlspecialchars_decode(htmlspecialchars_decode($product->author));
		echo "<p>$author</p>";
	echo "</div>";
	
	echo "<h4>Product description:</h4>";
	echo "<div>";
		// make html
		$page_description = htmlspecialchars_decode(htmlspecialchars_decode($product->description));
				
		// show to user
		echo "<p>$page_description</p>";
	echo "</div>";

	echo "<h4>Product category:</h4>";
	echo "<p>{$product->category_name}</p>";

echo "</div>";

echo "<div class='column-product'>";
	// if product was already added in the cart
	$cart_item->user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
	$cart_item->product_id=$id;

	// if product was already added in the cart
	if($cart_item->checkIfExists()){
		echo "<div class='border'>";
			echo "<p>This product is already in your cart.</p>";
		
			echo "<a href='{$home_url}cart.php'>";
			echo "Go to cart";
			echo "</a>";
		echo "</div>";
	}

	// if product was not added to the cart yet
	else{
		
		echo "<form class='add-to-cart-form'>";
			// product id
			echo "<div class='product-id'>{$id}</div>";

			// list variations
			$variation->product_id=$id;
			$stmt_variation=$variation->readByProductId();

			// count number of products returned
			$num_variation = $stmt_variation->rowCount();

			// if number of products returned is more than 0
			if($num_variation>0){
				echo "<div class='border'>";
					echo "<p>Select Size: </p>";
					echo "<select class='variation' style='font-size:14px'>";
													
						while ($row_variation = $stmt_variation->fetch(PDO::FETCH_ASSOC)){
							echo "<option value={$row_variation['id']}>";
								echo $row_variation['name'];
							echo "</option>";
						}
					echo "</select>";
								
					// select quantity
					echo "<p></p>";
					echo "<div class='quantity-container'></div>";
				echo "</div>";
			}else{
				echo "<div class='border'>";
					echo "<p>Stock not set.</p>";
					echo "<a href='{$home_url}contact.php'>Contact Us</a>";
				echo "</div>";
			}
		echo "</form>";
	}

echo "</div>";
echo "<div class='clear'></div>";
?>

<?php
echo "</div>";

// footer HTML and JavaScript codes
include_once 'layout_foot.php';
?>
