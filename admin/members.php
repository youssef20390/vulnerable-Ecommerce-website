<?php
session_start();
if(isset($_SESSION["username"])){
    $pageTitle = "Members";
    include "init.php"; 
    $do = "";
	if(isset($_GET["do"])){
        $do = $_GET["do"];
    }else{
        $do = "Manage";
    }

	// If The Page Is Main Page

	if ($do == 'Manage') {

            $query = "";
			if(isset($_GET['page']) && $_GET['page'] == 'pending' ){
				$query = "AND RegStatus = 0";

			}
		
			// Select All Users Except Admin 

			$stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
			

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();
			?>
		<h1 class="text-center">Manage Members</h1>
		<div class="container Table_container">
			<div class="table-responsive">
				<table class="main-table manage-members text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>Username</td>
						<td>Email</td>
						<td>Full Name</td>
						<td>Registered Date</td>
						<td>Control</td>
					</tr>
					<?php
					foreach($rows as $row) {
						echo "<tr>";
							echo "<td>" . $row['UserID'] . "</td>";
							echo "<td>" . $row['username'] . "</td>";
							echo "<td>" . $row['Email'] . "</td>";
							echo "<td>" . $row['FullName'] . "</td>";
							echo "<td>" . $row['Date'] ."</td>";
							echo "<td>
									<a href='members.php?do=Edit&id=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
									<a href='members.php?do=Delete&id=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
									if($row['RegStatus'] == 0){
										echo "<a href='members.php?do=Activate&id=" . $row['UserID'] . "' class='btn btn-info Activate'><i class='fa fa-close'></i> Activate </a>";
									}
							echo "</td>"; 
							
					}
					?>
				<tr>
				</table>
			</div>
			<a href="members.php?do=Add" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Member
			</a>
		</div>
			 

										
					
					
	<?php				
			
	}elseif ($do == 'Edit') {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]) ){
            $sql = "SELECT * FROM `users` WHERE `UserID`=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_GET["id"]]);
            $data = $stmt->fetchObject();
            if($data){
            ?>
                
				<h1 class="text-center">Edit Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $data->UserID ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="username" class="form-control" value="<?php echo $data->username  ?>" autocomplete="off" required="required" />
							</div>
						</div>
                        <br>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-8">
								<input type="hidden" name="oldpassword" value="<?php echo $data->password  ?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
							</div>
						</div>
                        <br>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-8">
								<input type="email" name="email" value="<?php echo $data->Email  ?>" class="form-control" required="required" />
							</div>
						</div>
                        <br>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" name="full" value="<?php echo $data->FullName  ?>" class="form-control" required="required" />
							</div>
						</div>
                        <br>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
    <?php
            }else{
				echo "no data";
			}
        }else{
			echo "id is wrong";
		}

 

	}elseif ($do == 'Update') {
        echo '<h1 class="text-center Edit">Edit Member</h1>';
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Get data
            $id 	= $_POST['userid'];
			$user 	= $_POST['username'];
			$email 	= $_POST['email'];
			$name 	= $_POST['full'];
            $pass = "";
            //password trick
            if(empty($_POST["newpassword"])){
                $pass = $_POST["oldpassword"];

            }else{
                $pass = password_hash($_POST["newpassword"],PASSWORD_DEFAULT);

            }
            //validation
            $formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
				}

				if (strlen($user) > 20) {
					$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'Username Cant Be <strong>Empty</strong>';
				}

				if (empty($name)) {
					$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
				}

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

            //updating
            if(empty($formErrors)){
            $sql = "UPDATE `users` SET `username`=?,`Email`=?,`FullName`=?,`password`=? WHERE `userid`=? ";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user,$email,$name,$pass,$id]);
            echo '<br><div class="alert alert-success text-center updated">Updated successfully</div>';
            };
        }else{
            echo "Invalid method";
        }

		

	}elseif ($do == 'Add') {
     ?>
		
        <h1 class="text-center">Add New Member</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Username Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop" />
						</div>
					</div>
					<!-- End Username Field -->
					<!-- Start Password Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-6">
							<input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password Must Be Hard & Complex" />
							<i class="show-pass fa fa-eye fa-2x"></i>
						</div>
					</div>
					<!-- End Password Field -->
					<!-- Start Email Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
						</div>
					</div>
					<!-- End Email Field -->
					<!-- Start Full Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
						</div>
					</div>
					<!-- End Full Name Field -->
					<!-- Start Avatar Field -->
					<!-- <div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">User Avatar</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="avatar" class="form-control" required="required" />
						</div>
					</div> -->
					<!-- End Avatar Field -->
                    <br>
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>
<?php
		
	}elseif ($do == 'Insert') {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user 	= $_POST['username'];
			$pass 	= $_POST['password'];
			$email 	= $_POST['email'];
			$name 	= $_POST['full'];

			$hashPass = password_hash($_POST['password'],PASSWORD_DEFAULT);

			// Validate The Form

			$formErrors = array();

			if (strlen($user) < 4) {
				$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
			}

			if (strlen($user) > 20) {
				$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
			}

			if (empty($user)) {
				$formErrors[] = 'Username Cant Be <strong>Empty</strong>';
			}

			if (empty($pass)) {
				$formErrors[] = 'Password Cant Be <strong>Empty</strong>';
			}

			if (empty($name)) {
				$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
			}

			if (empty($email)) {
				$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
			}

			// if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
			//     $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
			// }

			// if (empty($avatarName)) {
			//     $formErrors[] = 'Avatar Is <strong>Required</strong>';
			// }

			// if ($avatarSize > 4194304) {
			//     $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
			// }

			// Loop Into Errors Array And Echo It

			foreach($formErrors as $error) {
				echo '<div class="alert alert-danger">' . $error . '</div>';
			}
			$check = checkItem("Username","users",$user);
			$check2 = checkItem("Email","users",$email);
			if($check == 1 ){
				echo "<div class='alert alert-danger text-center' >This username already exist </div>";
			}elseif($check2 == 1 ){
				echo "<div class='alert alert-danger text-center' >This Email already exist </div>";
			}else{
				if (empty($formErrors)) {
					
					$sql = "INSERT INTO users (Username, Password, Email, FullName, RegStatus, Date) VALUES (:user, :pass, :mail, :name, 1, now() )";
					$stmt = $conn->prepare($sql);
					$stmt->execute([
						
						'user' 	=> $user,
						'pass' 	=> $hashPass,
						'mail' 	=> $email,
						'name' 	=> $name,
					]);
					echo '<h1 class="text-center">Add New Member</h1>';
					echo '<br><div class="alert alert-success text-center updated">Inserted successfully</div>';
						

				}
			};
		}else{
			$theMsg="you cant acess this page directly";
			redirectHome($theMsg,null);
	   	}

	}elseif($do == 'Delete') {
		echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$userid = intval($_GET['id']);
				}else{
					$userid = 0;
				}

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("DELETE FROM users WHERE UserID = :zuser");

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';


	}elseif($do == "Activate"){
		echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$userid = intval($_GET['id']);
				}else{
					$userid = 0;
				}

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("UPDATE users SET RegStatus=1 WHERE userid=?");


					$stmt->execute([$userid]);

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Members Activated</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID doesn\'t Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';
		
	
	}else {

		echo 'Error There\'s No Page With This Name';

	}





    
    include "includes/templates/footer.php";
}else{
    header("location:index.php");
    exit();
};
?>