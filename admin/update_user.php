<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
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
$page_title = "Update User";

// include page header HTML
include_once "layout_head.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

// get id of the user to be edited
$user_id=isset($_GET['id']) ? $_GET['id'] : die('Missing user ID.');

// set user id property
$user->id=$user_id;

// read user details
$user->readOne();

// read users button
echo "<div class='createLink'>";
	echo "<a href='{$home_url}admin/read_users.php' class='btn btn-primary pull-right'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Users";
	echo "</a>";
echo "</div>";
echo "<div class='clear'></div>";

// if HTML form was posted / submitted
if($_POST){
	
	// assigned posted values to object properties
	$user->firstname=$_POST['firstname'];
	$user->lastname=$_POST['lastname'];
	$user->email=$_POST['email'];
	$user->contact_number=$_POST['contact_number'];
	$user->address=$_POST['address'];
	$user->access_level=$_POST['access_level'];
	$user->id=$user_id;

	// update user information
	if($user->update()){

		// get currently logged in user first name
		$user->id=$_SESSION['user_id'];
		$user->readOne();

		// change saved firstname
		$_SESSION['firstname']=$user->firstname;

		// tell user details were updated
		header('Location: read_users.php?action=user_updated');
	}

	// tell user unable to update details
	else{
		echo "<br>";
		echo "<p>Unable to edit user.</p>";
	}
}
?>

<!-- HTML form to update user -->
<form action='update_user.php?id=<?php echo $user_id; ?>' method='post'>

	 <div class='table-responsive'>
		<table class='table table-hover table-bordered'>	

	        <tr>
	            <td width='30%'>Firstname</td>
	            <td width='70%'><input type='text' name='firstname' value="<?php echo $user->firstname; ?>" class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Lastname</td>
	            <td><input type='text' name='lastname' value="<?php echo $user->lastname; ?>" class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Contact Number</td>
	            <td><input type='text' name='contact_number' value="<?php echo $user->contact_number; ?>" class='form-control' required></td>
	        </tr>

			<tr>
	            <td>Address</td>
	            <td><textarea name='address' class='form-control' required><?php echo $user->address; ?></textarea></td>
	        </tr>

			<?php
			// if it is the first admin user, access level is automatically 'Admin'
			if($user_id==1){
				echo "<input type='hidden' name='access_level' value='Admin' />";
			}

			// else there's the choice, either the user will be 'Admin' or 'Customer'
			else{
			?>

			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">

						<!-- highlight the correct access level button -->
						<label class="btn btn-default <?php echo $user->access_level=='Customer' ? 'active' : ''; ?>">
							<input type="radio" name="access_level" value="Customer" <?php echo $user->access_level=='Customer' ? 'checked' : ''; ?>> Customer
						</label>

						<label class="btn btn-default <?php echo $user->access_level=='Admin' ? 'active' : ''; ?>">
							<input type="radio" name="access_level" value="Admin" <?php echo $user->access_level=='Admin' ? 'checked' : ''; ?>> Admin
						</label>

					</div>
				</td>
	        </tr>

			<?php
			}
			?>

			<tr>
	            <td>Email</td>
	            <td><input type='email' name='email' value="<?php echo $user->email; ?>" class='form-control' required></td>
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
	</div>	
</form>

<?php
// include page footer HTML
include_once "layout_foot.php";
?>
