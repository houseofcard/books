<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once "../libs/php/utils.php";
include_once '../objects/user.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// initialize utility class
$utils = new Utils();

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$order = new Order($db);

// set page title
$page_title = "Create User";

// include page header HTML
include_once "layout_head.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

// read users button
echo "<div class='createLink'>";
	echo "<a href='{$home_url}admin/read_users.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Users";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";


// if the form was submitted
if($_POST){
			
	// set user property values
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
		echo "<br>";
		echo "<p>Email already exists in our databse.</p>";
		echo "<p>Try again with a different email.</p>";
	}

	else{
				
		// create the user
		if($user->create()) {
		
			// tell admin new user was created
			echo "<br>";
			echo "<p>User was created.</p>";
		}

		// tell admin unable to create new user
		else{
			echo "<br>";
			echo "<p>Unable to create user.</p>";
		}
	}	
}
?>
	
<!-- HTML form for creating a user -->
<form action='create_user.php' method='post' id='create-user'>

	 <div class='table-responsive'>
		<table class='table table-hover table-bordered'>	

	        <tr>
	            <td width='30%'>Firstname</td>
	            <td width='70%'><input type='text' name='firstname' class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Lastname</td>
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

						<label class="btn btn-default">
							<input type="radio" name="access_level" value="Admin"> Admin
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
	</div>
</form>

<?php
// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
