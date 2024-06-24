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

		
			// Select All Users Except Admin 

			$stmt = $conn->prepare("SELECT comments.*,items.Name,users.username
                                    FROM comments
                                    INNER JOIN items
                                    ON comments.item_id = items.Item_ID
                                    INNER JOIN users
                                    ON comments.user_id = users.UserID");
			

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();
			?>
		<h1 class="text-center">Manage Comments</h1>
		<div class="container Table_container">
			<div class="table-responsive">
				<table class="main-table manage-members text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>comment</td>
						<td>username</td>
						<td>Item Name</td>
						<td>Added Date</td>
						<td>Control</td>
					</tr>
					<?php
					foreach($rows as $row) {
						echo "<tr>";
							echo "<td>" . $row['c_id'] . "</td>";
							echo "<td>" . $row['comment'] . "</td>";
							echo "<td>" . $row['username'] . "</td>";
							echo "<td>" . $row['Name'] . "</td>";
							echo "<td>" . $row['comment_date'] ."</td>";
							echo "<td>
									<a href='comments.php?do=Delete&id=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
							echo "</td>"; 
							
					}
					?>
				<tr>
				</table>
			</div>
		</div>
			 

										
					
					
	<?php				
	

	}elseif($do == 'Delete') {
		echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$commid = intval($_GET['id']);
				}else{
					$commid = 0;
				}
               

				// Select All Data Depend On This ID

				$check = checkItem('c_id', 'comments', $commid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("DELETE FROM comments WHERE c_id = :id");

					$stmt->bindParam(":id", $commid);

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