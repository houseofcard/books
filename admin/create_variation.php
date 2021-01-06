 <?php
// include core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once "../objects/category.php";
include_once "../objects/variation.php";
include_once "../objects/product.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);
$variation = new Variation($db);
$product = new Product($db);
$order = new Order($db);

// create product id
$product_id=isset($_GET['product_id']) ? $_GET['product_id'] : "Product ID not found.";

// set ID property of product
$product->id = $product_id;

// read the details of product
$product->readOne();

// set page title
$page_title = "<small>Create Variation of </small><br />{$product->name}";

// import page header HTML
include_once "layout_head.php";

// read variations button
echo "<div class='createLink'>";
	echo "<a href='variations.php?product_id={$product_id}' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Variations";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";	

// if the form was submitted
if($_POST){
			
	// set variation property values
	$variation->product_id=$product_id;
	$variation->name=$_POST['name'];

	$variation->price=$_POST['price'];
	$variation->stock=$_POST['stock'];

	// create the variation
	if($variation->create()){
			
		// tell admin new variation was created
		echo "<p>Variation was created.</p>";
	}

	// tell admin unable to create new variation
	else{
		echo "<p>Unable to create variation.</p>";
	}
}
?>

<!-- HTML form for creating a variation -->
<form action='create_variation.php?product_id=<?php echo $product_id; ?>' method='post' enctype="multipart/form-data">

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>
			<tr>
				<td width='30%'>Name</td>
				<td width='70%'><input type='text' name='name' class='form-control' required /></td>
			</tr>

	        <tr>
				<td>Price</td>
				<td><input type='text' name='price' class='form-control' required /></td>
			</tr>

	        <tr>
	            <td>Stock</td>
	            <td><input type='number' name='stock' class='form-control' required /></td>
	        </tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-plus'></span> Create
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
