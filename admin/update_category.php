<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once "../objects/category.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$category = new Category($db);

// set page title
$page_title = "Update Category";

// include page header HTML
include_once "layout_head.php";

// get id of category to be edited
$category_id=isset($_GET['id']) ? $_GET['id'] : die('Missing category ID.');

// set category id property
$category->id = $category_id;

// read category details
$category->readOne();

// read categories button
echo "<div class='createLink'>";
	echo "<a href='{$home_url}admin/read_categories.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Categories";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";

// if HTML form was submitted / posted
if($_POST){
	
	// assigned posted values to object properties
	$category->name=$_POST['name'];
	$category->description=$_POST['description'];
		
	// update category information
	if($category->update()){

	// tell admin category details were updated
		echo "<br>";
		echo "<p>Category was updated.</p>";
	}

	// tell admin unable to update category details
	else{
		echo "<br>";
		echo "<p>Unable to update category.</p>";
	}
}
?>

<!-- HTML form to update category -->
<form action='update_category.php?id=<?php echo $category_id; ?>' method='post'>

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>

	        <tr>
	            <td class='width-30-percent'>Name</td>
	            <td><input type='text' name='name' value="<?php echo $category->name; ?>" class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Description</td>
	            <td><input type='text' name='description' value="<?php echo $category->description; ?>" class='form-control' required></td>
	        </tr>

			<tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Save Changes
					</button>
	            </td>
	        </tr>
	    </table>
	</div>
</form>

<?php
// include page footer HTML
include_once "layout_foot.php";
?>
