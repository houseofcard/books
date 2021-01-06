<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/product.php';
include_once '../objects/product_image.php';
include_once '../objects/product_pdf.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$product_pdf = new ProductPdf($db);
$category = new Category($db);
$order = new Order($db);

// set page title
$page_title = "Update Product";

// include page header HTML
include_once "layout_head.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

// get ID of the product to be edited
$product_id = isset($_GET['id']) ? $_GET['id'] : die('Missing product ID.');

// set product id property
$product->id = $product_id;

// read product details
$product->readOne();

// read products button
echo "<div class='createLink'>";
	echo "<a href='read_products.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Products";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";	

// if the form was posted / submitted
if($_POST){
	
	// assigned posted values to object properties
	$product->name = $_POST['name'];
	$product->description = $_POST['description'];
	$product->category_id = $_POST['category_id'];
	$product->active_until = $_POST['active_until'];
	// update product information
	if($product->update()){

		// save the images
		$product_image->product_id = $product_id;
		$product_image->upload();

		// tell admin prouct details were updated
		echo "<p>Product was updated.</p>";
	}

	// tell admin unable to update product details
	else{
		echo "<p>Unable to update product.</p>";
	}
}
?>

<!-- HTML form to update product -->
<form action='update_product.php?id=<?php echo $product_id; ?>' method='post' enctype="multipart/form-data">

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>
			
			<tr>
				<td width='30%'>Name</td>
				<td width='70%'><input type='text' name='name' value="<?php echo $product->name; ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td>Description</td>
				<td><textarea name='description' class='form-control' required><?php echo $product->description; ?></textarea></td>
			</tr>

			<tr>
				<td>Category</td>
				<td>
					<?php
					// read the product categories from the database
					include_once '../objects/category.php';

					$category = new Category($db);
					$stmt = $category->readAll_WithoutPaging();

					// put them in a select drop-down
					echo "<select class='variation' style='font-size:14px' name='category_id'>";

						echo "<option>Please select...</option>";
						while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row_category);

							// current category of the product must be selected
							if($product->category_id==$id){
								echo "<option value='$id' selected>";
							}else{
								echo "<option value='$id'>";
							}

							echo "$name</option>";
						}
					echo "</select>";
					?>
				</td>
			</tr>

			<tr>
				<td>Active Until:</td>
				<td>
					<!-- we are using jQuery UI as data picker -->
					<input type="text" name='active_until' id="active-until" value='<?php echo substr($product->active_until, 0, 10); ?>' class='form-control' placeholder="Click to pick date" />
				</td>
			</tr>

			<tr>
				<td>Image(s):</td>
				<td>
					<?php
					// set product id
					$product_image->product_id=$product_id;

					// read all images under the product id
					$stmt_product_image = $product_image->readAll();

					// count number of images under a product id
					$num_product_image = $stmt_product_image->rowCount();

					// if retrieved images greater was than 0
					if($num_product_image>0){

						// loop through the retrieved product images
						while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){

							// product image id and name
							$product_image_id = $row['id'];
							$product_image_name = $row['name'];

							// image source
							$image_source="{$home_url}uploads/images/{$product_image_name}";

							// display the image(s)
							echo "<img src='{$image_source}' Width='50' Height='75'/>";
							echo "<br>";
							echo "<a delete-id='{$product_image_id}' file='image' class='delete-object'>Delete Image?</a>";
							echo "<br>";
							echo "<br>";
						}
					}
					?>
					
					<!-- field to browse multiple image records -->
					<input type="file" name="files[]" class='form-control' multiple>
			
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td>
					<div class='m-b-10px'>Need to set variation, price and stock?</div>
					<a href="<?php echo "{$home_url}admin/variations.php?product_id={$product_id}"; ?>" class='btn btn-info'>Click Here</a>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-edit'></span> Update
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
