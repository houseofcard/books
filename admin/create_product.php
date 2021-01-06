<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);

// set page title
$page_title = "Create Product";

// include page header HTML
include_once "layout_head.php";

// read products button
echo "<div class='createLink'>";
	echo "<a href='read_products.php' class='btn btn-primary'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Products";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";


// if the form was submitted
if($_POST){
					
	// instantiate product object
	include_once '../objects/product.php';
	include_once '../objects/product_image.php';
		
	$product = new Product($db);
	$productImage = new ProductImage($db);
		
	// set product property values
	$product->name = $_POST['name'];
	$product->author = $_POST['author'];
	$product->description = $_POST['description'];
	$product->category_id = $_POST['category_id'];
	$product->active_until = $_POST['active_until'];

	// create the product
	if($product->create()){
			
		// get last inserted id
		$product_id=$db->lastInsertId();
		// save the images
		$productImage->product_id = $product_id;
		$productImage->upload();
			
		// tell admin new product was created
		echo "<p>Product was created.</p>";
	}

	// tell admin unable to create new product
	else{
		echo "<p>Unable to create product.</p>";
	}
}
?>

<!-- HTML form for creating a product -->
<form action='create_product.php' method='post' enctype="multipart/form-data">

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>
			
			<tr>
				<td width='30%'>Name</td>
				<td width='70%'><input type='text' name='name' class='form-control' required></td>
			</tr>
			
			<tr>
				<td width='30%'>Author</td>
				<td width='70%'><input type='text' name='author' class='form-control' required></td>
			</tr>

			<tr>
				<td>Description</td>
				<td><textarea name='description' class='form-control'></textarea></td>
			</tr>

			<tr>
				<td>Category</td>
				<td>
				<?php
				// read the categories from the database
				$stmt = $category->readAll_WithoutPaging();

				// put them in a select drop-down
				echo "<select class='variation' style='font-size:14px' name='category_id'>";	
					echo "<option>Select category...</option>";

					// loop through the categories
					while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row_category);
						echo "<option value='{$id}'>{$name}</option>";
					}
	
					echo "</select>";
				?>
				</td>
			</tr>

			<tr>
				<td>Active Until:</td>
				<td>
					<!-- uses jQuery UI date picker -->
					<input type="text" name='active_until' id="active-until" class='form-control' placeholder="yyyy-mm-dd" />
				</td>
			</tr>

			<tr>
				<td>Image(s):</td>
				<td>
					<!-- browse multiple image files -->
					<input type="file" name="files[]" class='form-control' multiple>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<p>You'll be able to set variations, price and stock once a product was created.</p>
				</td>
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
