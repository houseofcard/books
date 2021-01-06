<!-- styling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/admin.css">

<div class="menu" id="myTopnav">
<!--<div class="navbar navbar-fixed-top  navbar-inverse">   -->
		
	<!-- Change "Your Site" to your site name -->
	<a href="<?php echo $home_url; ?>admin/read_products.php">BooksGaloreWebstore</a>
	
	<div class="dropdown">
	
		<div class="dropbtn">
			<a href="#" class="drop">Products&nbsp;<i class="fa fa-caret-down"></i></a>
		</div>
				
		<div class="dropdown-content">
			<a href="<?php echo $home_url; ?>admin/read_products.php">Active Products</a>
				<a href="<?php echo $home_url; ?>admin/read_inactive_products.php">Inactive Products</a>
				<?php
					// read all categories
					$stmt=$category->readAll_WithoutPaging();
					$num = $stmt->rowCount();

					// loop through retrieved categories
					if($num>0){
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

							// higlight if current category name was set and is the same with the category on current loop
							if(isset($category_name) && $category_name==$row['name']){
								echo "<li class='active'><a href='{$home_url}admin/category.php?id={$row['id']}'>{$row['name']}</a></li>";
							}

							// no highlight
							else{
								echo "<li><a href='{$home_url}admin/category.php?id={$row['id']}'>{$row['name']}</a></li>";
							}
						}
					}
				?>
		</div>			
	</div>	
	
	<a href="<?php echo $home_url; ?>admin/read_orders.php">Orders</a>
	<a href="<?php echo $home_url; ?>admin/read_users.php">Users</a>
	<a href="<?php echo $home_url; ?>admin/read_categories.php">Categories</a>
	
	
	<div class="dropdown">
	
		<div class="dropbtn">
			<a href="#" class="drop"><?php echo $_SESSION['firstname']; ?>&nbsp;<i class="fa fa-caret-down"></i></a>
		</div>
				
		<div class="dropdown-content">
			<a href="<?php echo $home_url; ?>admin/update_user.php?id=<?php echo $_SESSION['user_id']; ?>">Edit Profile</a>
			<a href="<?php echo $home_url; ?>admin/change_password.php">Change Password</a>
			<a href="<?php echo $home_url; ?>logout.php">Logout</a>
		</div>			
	</div>	
	
	<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>	
	
	<!--</div>-->
	
	
	
</div>	

<script>
function myFunction() {
   var x = document.getElementById("myTopnav");
  if (x.className === "menu") {
    x.className += " responsive";
  } else {
    x.className = "menu";
  }
}
</script>


