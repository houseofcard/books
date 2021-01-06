<?php

// if it is the 'edit profile' or 'orders' or 'place order' or 'change password' page, require a login
if(isset($page_title) && ($page_title=="Edit Profile" || $page_title=="Orders" || $page_title=="Place Order" || $page_title=="Change Password")){
	
	// if user not yet logged in, redirect to login page
	if(!isset($_SESSION['access_level'])){
		header("Location: {$home_url}login.php?action=please_login");
	}
}

// if it was the 'login' or 'register' page but the customer was already logged in
if(isset($page_title) && ($page_title=="Login" || $page_title=="Register")){
	// if user not yet logged in, redirect to login page
	if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Customer"){
		header("Location: {$home_url}products.php?action=already_logged_in");
	}
}

?>