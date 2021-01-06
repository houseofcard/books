<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once "libs/php/utils.php";
include_once 'objects/user.php';
include_once "objects/category.php";
include_once "objects/order.php";
include_once "objects/cart_item.php";

// initialize utility class
$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$order = new Order($db);
$cart_item = new CartItem($db);

// set page title
$page_title = "Register";

// include login checker
include_once "login_checker.php";

// include page header HTML
include_once "layout_head.php";

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";

// if HTML form was posted / submitted
if($_POST){
	echo "<div>";
			
	// assigned posted values to object properties
	$user->firstname=$_POST['firstname'];
	$user->lastname=$_POST['lastname'];
	$user->email=$_POST['email'];
	$user->contact_number=$_POST['contact_number'];
	$user->address=$_POST['address'];
	$user->password=$_POST['password'];
	$user->status=1;
	$user->access_level=$_POST['access_level'];

	// access code for email verification
	$access_code=$utils->getToken();
	$user->access_code=$access_code;

	// make sure do not create another user when that user already exists
	if($user->emailAlreadyExists()){
		echo "<p>Email already exists in our databse.</p>";
		echo "<p>Try again with a different email.</p>";
	}
	else{		
		
		// create the user
		if($user->create()){
			
			// tell user new user was created
			echo "<p>User was created.</p>";
		}

		// tell user unable to create new user
		else{
			echo "<p>Unable to create user.</p>";
		}
	}	
	echo "</div>";
}

echo "<div>";
	?>
	<div>
	<!-- HTML form to create the user -->
	<form action='register.php' method='post' id='register'>

	    <table class='table table-hover table-responsive'>

	        <tr>
	            <td width='30%'>First Name</td>
	            <td width='70%'><input type='text' name='firstname' class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Last Name</td>
	            <td><input type='text' name='lastname' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Contact Number</td>
	            <td><input type='text' name='contact_number' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Address</td>
	            <td><textarea name='address' class='form-control' required></textarea></td>
	        </tr>

			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default active">
							<input type="radio" name="access_level" value="Customer" checked> Customer
						</label>
					</div>
				</td>
	        </tr>

			<tr>
	            <td>Email</td>
	            <td><input type='email' name='email' class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Password</td>
	            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
	        </tr>

			<tr>
	            <td>Confirm Password</td>
	            <td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput'>
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
	        </tr>

	        <tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus"></span> Create User
					</button>
	            </td>
	        </tr>

	    </table>
	</form>
	</div>
	<?php
echo "</div>";

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>