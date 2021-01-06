<?php
// core configuration
include_once "../config/core.php";

// include login checker
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/user.php';
include_once "../objects/category.php";
include_once "../objects/order.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$order = new Order($db);

// set page title
$page_title = "Change Password";

// include page header HTML
include_once "layout_head.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

// if HTML form was posted / submitted
if($_POST){

	// read user details to get current password
	// read user record based on session user id value
	$user->id=$_SESSION['user_id'];
	$user->readOne();

	// check if submitted current_password is correct
	if(password_verify($_POST['current_password'], $user->password)){

		// new password
		$user->password=$_POST['password'];

		// get user id from session
		$user->id=$_SESSION['user_id'];

		// update user information
		if($user->changePassword()){

			// tell the user it was updated
			echo "<br>";
			echo "<p>Password was changed.</p>";
		}

		// tell the user update was failed
		else{
			echo "<br>";
			echo "<p>Unable to change password.</p>";
		}
	}

	// if submitted current password is wrong
	else{
		echo "<br>";
		echo "<p>Current password is incorrect.</p>";
	}
}
?>
<!-- HTML form to update user -->
<form action='change_password.php' method='post'>
		
	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>

            <tr>
				<td width='30%'>Current Password</td>
				<td width='70%'><input type='password' name='current_password' class='form-control' required /></td>
			</tr>

			<tr>
				<td>New Password</td>
				<td><input type='password' name='password' class='form-control' required id='passwordInput' /></td>
			</tr>

			<tr>
				<td>Re-type New Password</td>
				<td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput' />
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Change Password
					</button>
				</td>
			</tr>

		</table>
	</div>
</form>

<?php
//footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
