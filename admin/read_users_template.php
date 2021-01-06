<!-- search product function -->
<div>
	<div class="searchBox">
		<form role="searchBox" action='search_users.php'>
			<input type="text" placeholder="Type email address..." size="15" name="s" required <?php echo isset($search_term) ? "value='$search_term'" : ""; ?> />
			<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		</form>
	</div>
	<div class="clear"></div>

	<!-- create user form -->
	<div class="createLink">
		<a href='create_user.php' class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Create User
		</a>
	</div>
	<div class="clear"></div>
</div>

<?php

if ($action=='user_deleted') {	
	echo"<p>User was deleted!</p>";
}
else if($action=='user_updated') {
	echo"<p>User was updated!</p>";
}

// display the table if the number of users retrieved was greater than zero
if($num>0){
	
	echo "<div class='table-responsive'>";
		echo "<table class='table table-hover table-bordered'>";
			
			// table headers
			echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Name</th>";
				echo "<th>Access Level</th>";
				echo "<th>Email</th>";
				echo "<th>Contact Number</th>";
				echo "<th>Address</th>";
				echo "<th>Actions</th>";
			echo "</tr>";

			// loop through the user records
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				// display user details
				echo "<tr>";
					echo "<td>{$id}</td>";
					echo "<td>{$firstname} {$lastname}</td>";
					echo "<td>{$access_level}</td>";
					echo "<td>{$email}</td>";
					echo "<td>{$contact_number}</td>";
					echo "<td>{$address}</td>";
				
					echo "<td>";

					// edit button
						echo "<a href='{$home_url}admin/update_user.php?id={$id}' class='btn btn-info btn-block'>";
							echo "<span class='glyphicon glyphicon-edit'></span> Edit";
						echo "</a>";

						// delete button, user with id # 1 cannot be deleted because it is the first admin
						if($id!=1){
							// delete product button
							echo "<a delete-id='{$id}' file='user' class='btn btn-danger delete-object btn-block'>";
								echo "<span class='glyphicon glyphicon-remove'></span> Delete";
							echo "</a>";
											
							echo "<a href='{$home_url}admin/order_history.php?id={$id}' class='btn btn-primary btn-block'>";
								echo "Order History";
							echo "</a>";
						}
					echo "</td>";
				echo "</tr>";
			}
			
		echo "</table>";
	echo "</div>";
		
	// the number of rows retrieved on that page
	$total_rows=0;

	// user search results
	if(isset($search_term) && $page_url=="search_users.php?s={$search_term}&"){
		$total_rows = $user->countAll_BySearch($search_term);
	}

	// all users
	else if($page_url=="read_users.php?"){
		$total_rows = $user->countAll();
	}

	// actual paging buttons
	include_once 'paging.php';
}

// tell the user there are no selfies
else{
	echo "<br>";
	echo "<p>No users found.</p>";
}
?>
