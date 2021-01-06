<!-- search category function -->
<div class="searchBox">
	<form role="search" action='search_categories.php'>
		<input type="text" placeholder="Type a category..." size="15" name="s" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
		<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	</form>
</div>
<div class="clear"></div>
	
<!-- create category button -->
<div class="createLink">
	<a href='create_category.php' class="btn btn-primary">
		<span class="glyphicon glyphicon-plus"></span> Create Category
	</a>
</div>
<div class="clear"></div>


<?php

if ($action=='category_deleted') {	
	echo"<p>Category was deleted!</p>";
}	

// display the table if the number of categories retrieved is greater than zero
if($num>0){
	
	echo "<div class='table-responsive'>";
		echo "<table class='table table-hover table-bordered'>";
		
	   // echo "<table class='table table-hover table-responsive table-bordered'>";

			// table headers
	        echo "<tr>";
				echo "<th>Name</th>";
	            echo "<th>Description</th>";
				echo "<th>Actions</th>";
	        echo "</tr>";

			// loop through the category records
	        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				// display category details
	            echo "<tr>";
					echo "<td>{$name}</td>";
	                echo "<td>{$description}</td>";
					
	                echo "<td>";

						// edit button
						echo "<a href='{$home_url}admin/update_category.php?id={$id}' class='btn btn-info btn-block'>";
							echo "<span class='glyphicon glyphicon-edit'></span> Edit";
						echo "</a>";
						
						// delete button
						echo "<a delete-id='{$id}' file='category' class='btn btn-danger delete-object btn-block'>";
							echo "<span class='glyphicon glyphicon-remove'></span> Delete";
						echo "</a>";
						
					echo "</td>";
	            echo "</tr>";
	        }

	    echo "</table>";
	echo "</div>";

	// the number of rows retrieved on that page
	$total_rows=0;

	// category search results
	if(isset($search_term) && $page_url=="search_categories.php?s={$search_term}&"){
		$total_rows = $category->countAll_BySearch($search_term);
	}

	// all categories
	else if($page_url=="read_categoriess.php?"){
		$total_rows = $user->countAll();
	}

	// actual paging buttons
	include_once 'paging.php';
}

// tell the user if there are no categories in the database

else{
	echo "<br>";
		echo "<p>No categories found.</p>";
}
?>
