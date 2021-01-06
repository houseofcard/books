<!-- styling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="libs/css/user_orders.css">

<!-- menu -->
<div class="menu" id="myTopnav">
	
	<!-- Change "Your Site" to your site name -->
	<a href="<?php echo $home_url; ?>products.php">BooksGaloreWebstore</a>
	
	<?php
	// check if users / customer was logged in
	// if user was logged in, show "Edit Profile", "Orders" and "Logout" options
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
	?>
		<div class="dropdown">
	
			<div class="dropbtn">
				<a href="#" class="drop"><?php echo $_SESSION['firstname']; ?>&nbsp;<i class="fa fa-caret-down"></i></a>
				
			</div>
	
			<div class="dropdown-content">
				<a href="<?php echo $home_url; ?>edit_profile.php">Edit Profile</a>
				<a href="<?php echo $home_url; ?>change_password.php">Change Password</a>
				<a href="<?php echo $home_url; ?>orders.php">Orders</a>
				<a href="<?php echo $home_url; ?>logout.php">Logout</a>
				
  			</div>
		</div>		
	<?php
	}
	
	// if user was not logged in, show the "login" and "sign up" options
	else{
	?>
		<a href="<?php echo $home_url; ?>login.php"><i class="glyphicon glyphicon-user"></i>  Log In</a>
		<a href="<?php echo $home_url; ?>register.php">Register</a>
				
	<?php
	}
	?>
	
		<!-- link to the "Cart" page, highlight if current page is cart.php -->
		<a href="<?php echo $home_url; ?>cart.php">
	
	<?php
		// return count, session user_id was set in core.php
		$cart_item->user_id=$_SESSION['user_id'];
		// echo "UID: " . $_SESSION['user_id'];
		$cart_count=$cart_item->countAll();
	?>
		Cart <?php echo $cart_count; ?> Items <i class="glyphicon glyphicon-shopping-cart"></i>
		</a>
		
		<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
		<!--<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		<i class="glyphicon glyphicon-menu-hamburger"></i>-->
	</a>
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