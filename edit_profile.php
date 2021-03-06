<?php
// core configuration
include_once "config/core.php";

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/user.php';
include_once "objects/category.php";
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$user = new User($db);
$category = new Category($db);
$cart_item = new CartItem($db);

// set page title
$page_title = "Edit Profile";

// include login checker
include_once "login_checker.php";

// include page header HTML
include_once "layout_head.php";

echo "<div>";

	// if HTML form was posted / submitted
	if($_POST){

		// assigned posted values to object properties
		$user->firstname=$_POST['firstname'];
		$user->lastname=$_POST['lastname'];
		$user->email=$_POST['email'];
		$user->contact_number=$_POST['contact_number'];
		$user->address=$_POST['address'];
		$user->access_level="Customer";

		// get user id from session
		$user->id=$_SESSION['user_id'];

		// update user information
		if($user->update()){

			// change saved firstname
			$_SESSION['firstname']=$_POST['firstname'];

			// tell the user it was updated
			echo "<p>Changes were saved.</p>";
		}

		// tell the user update was failed
		else{
			echo "<p>Unable to update user.</p>";
		}
	}

	// read user record based on session user id value
	$user->id=$_SESSION['user_id'];
	$user->readOne();
	?>
	<div>
	<!-- HTML form to update user -->
	<form action='edit_profile.php' method='post' id='edit-profile'>

		<table class='table table-hover table-responsive'>

			<tr>
				<td width='30%'>First Name</td>
				<td width='70%'>
					<input type='text' name='firstname' value="<?php echo htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required>
				</td>
			</tr>

			<tr>
				<td>Last Name</td>
				<td><input type='text' name='lastname' value="<?php echo htmlspecialchars($user->lastname, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td>Contact Number</td>
				<td><input type='text' name='contact_number' value="<?php echo htmlspecialchars($user->contact_number, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td>Address</td>
				<td><textarea name='address' class='form-control' required><?php echo htmlspecialchars($user->address, ENT_QUOTES, 'UTF-8'); ?></textarea></td>
			</tr>

			<tr>
				<td>Email</td>
				<td><input type='email' name='email' value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit User
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