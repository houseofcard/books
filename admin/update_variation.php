<?php
// include core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once "../objects/category.php";
include_once "../objects/variation.php";
include_once "../objects/product.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);
$variation = new Variation($db);
$product = new Product($db);

// get id of product to be edited
$product_id=isset($_GET['product_id']) ? $_GET['product_id'] : "Product ID not found.";

// set product ID property
$product->id = $product_id;

// read product details
$product->readOne();

// set page title
$page_title = "<small>Update Variation of </small><br />{$product->name}";

// include page header HTML
include_once "layout_head.php";

// get id of product variation to be edited
$id=isset($_GET['id']) ? $_GET['id'] : "Variation ID not found.";

// set variation id property 
$variation->id = $id;

// read variation details
$variation->readOne();

// read variations button
echo "<div class='createLink'>";
	echo "<a href='variations.php?product_id={$product_id}' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Variations";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";	

// if HTML form was posted / submitted
if($_POST){
	
	// set variation property values
	$variation->product_id=$product_id;
	$variation->name=$_POST['name'];
	$variation->price=$_POST['price'];

	$stock=$_POST['stock']>=1 ? $_POST['stock'] : 1;
	$variation->stock=$stock;

	// update variation information
	if($variation->update()){

		// tell admin variation deatils were updated
		echo "<p>Variation was updated.</p>";
	}

	// tell admin unable to update variation deatils
	else{
		echo "<p>Unable to update variation.</p>";
	}
}
?>

<!-- HTML form for creating a variation -->
<form action='<?php echo "update_variation.php?id={$id}&product_id={$product_id}"; ?>' method='post'>

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>

			<tr>
				<td width='30%'>Name</td>
				<td width='70%'><input type='text' name='name' value="<?php echo $variation->name; ?>" class='form-control' required /></td>
			</tr>

	        <tr>
				<td>Price</td>
				<td><input type='text' name='price' value="<?php echo $variation->price; ?>" class='form-control' required /></td>
			</tr>

	        <tr>
	            <td>Stock</td>
	            <td><input type='number' name='stock' value="<?php echo $variation->stock; ?>" class='form-control' required min='1' /></td>
	        </tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-plus'></span> Save Changes
					</button>
				</td>
			</tr>

		</table>
	</div>
</form>

<?php
// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
