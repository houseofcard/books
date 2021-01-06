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
$page_title = "Create Category";

// include page header HTML
include_once "layout_head.php";

// read categories button
echo "<div class='createLink'>";
	echo "<a href='read_categories.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Categories";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";

// if the form was submitted
if($_POST){
		
	// set category property values
	$category->name = $_POST['name'];
	$category->description = $_POST['description'];
		
	// create the category
	if($category->create()){

		// tell admin new category was created
		echo "<br>";
		echo "<p>Category was created.</p>";
	}

	// tell admin unable to create new category
	else{
		echo "<br>";
		echo "<p>Unable to create category.</p>";
	}
}
?>

<!-- HTML form for creating a category -->
<form action='create_category.php' method='post' enctype="multipart/form-data">

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>	
			<tr>
				<td class='30%'>Name</td>
				<td class='70%'><input type='text' name='name' class='form-control' required></td>
			</tr>

			<tr>
				<td>Description</td>
				<td><textarea name='description' class='form-control' required></textarea></td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-plus'></span>Create Category
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
</body>
</html>