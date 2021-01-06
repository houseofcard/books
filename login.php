<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once "config/database.php";

// include objects and classes
include_once "libs/php/utils.php";
include_once "objects/category.php";
include_once 'objects/user.php';
include_once 'objects/cart_item.php';

// initialize utility class
$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";

// initialize objects
$category = new Category($db);
$user = new User($db);
$cart_item = new CartItem($db);

// set page title
$page_title = "Login";

// include login checker
include_once "login_checker.php";

// default to false
$access_denied=false;

// if the login form was submitted
if($_POST){
		
	// check if email and password are in the database
	$user->email=$_POST['email'];

	// check if email exists, also get user details using this emailExists() method
	$email_exists = $user->emailExists();

	// validate login
	if($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){	
	//if($email_exists && $user->status==1){	
		// check if valid temporary user id exists
		if(isset($_SESSION['user_id'])){
			// update cart_items in the database
			$cart_item->user_id=$user->id;
			$cart_item->updateUserId();
		}

		// set retrieved user_id to cookie user_id
		setcookie("user_id", $user->id);

		// set the session value to true
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user->id;
		$_SESSION['access_level'] = $user->access_level;
		$_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
		$_SESSION['lastname'] = $user->lastname;

		// if access level is 'Admin', redirect to admin section
		if($user->access_level=='Admin'){
			header("Location: {$home_url}admin/read_products.php?action=login_success");
		}

		// else, redirect only to 'Customer' section
		else{
			header("Location: {$home_url}products.php?action=login_success");
		}
	}

	// if username does not exist or password is wrong
	else{
		$access_denied=true;
	}
}

// include page header HTML
include_once "layout_head.php";

// create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";
?>

<div>
<?php
// tell the user he is not yet logged in
if($action =='not_yet_logged_in'){
	echo "<p>Please login.</p>";
}

// tell the user to login
else if($action=='please_login'){
	echo "<p>Please login to access that page.</p>";
}

// tell the user if access denied
if($access_denied){
	echo "<p>Access Denied.</p>";
	echo "<p>Your username or password maybe incorrect.</p>";
	echo "<br>";
	echo "<p>If you have fogotten your username or password</p>  ";
	echo "<p><a href='{$home_url}contact.php'>Contact Us</a></p>";
	echo "<br>";
}
?>
	<div>
		<form class="form-signin" action="login.php" method="post">
			<input type="text" name="email" class="form-control" placeholder="Email" required autofocus />
			<input type="password" name="password" class="form-control" placeholder="Password" required />
			<br>
			<input type="submit" class="btn btn-primary" value="Log In" />
		</form>
	</div>
</div>

<?php
// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>