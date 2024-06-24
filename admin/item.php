<?php

	/*
	================================================
	== Template Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();
if(isset($_SESSION["username"])){
    $pageTitle = "categories";
    include "init.php"; 
    $do = "";
	if(isset($_GET["do"])){
        $do = $_GET["do"];
    }else{
        $do = "Manage";
    }

		if ($do == 'Manage') {
           
		
			// Select All Users Except Admin 

			$stmt = $conn->prepare("SELECT items.*,users.username,categories.Cat_Name
                                    FROM items
                                    INNER JOIN users 
                                    ON items.Member_ID = users.UserID
                                    INNER JOIN categories 
                                    ON items.Cat_ID = categories.ID ");
			

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$items = $stmt->fetchAll();
			?>
		<h1 class="text-center">Manage Items</h1>
		<div class="container Table_container">
			<div class="table-responsive">
				<table class="main-table manage-members text-center table table-bordered">
					<tr>
						<td>#ID</td>
						<td>Name</td>
						<td>Description</td>
						<td>Price</td>
						<td>Date</td>
						<td>Category</td>
						<td>User</td>
						<td>Control</td>
					</tr>
					<?php
					foreach($items as $item) {
						echo "<tr>";
							echo "<td>" . $item['Item_ID'] . "</td>";
							echo "<td>" . $item['Name'] . "</td>";
							echo "<td>" . $item['Description'] . "</td>";
							echo "<td>" . $item['Price'] . "</td>";
							echo "<td>" . $item['Add_Date'] ."</td>";
							echo "<td>" . $item['Cat_Name'] ."</td>";
							echo "<td>" . $item['username'] ."</td>";
							echo "<td>
									<a href='item.php?do=Edit&id=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
									<a href='item.php?do=Delete&id=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                    if($item['RegStatus'] == 0){
										echo "<a href='item.php?do=Approve&id=" . $item['Item_ID'] . "' class='btn btn-info Activate'><i class='fa fa-check'></i> Activate </a>";
									}
							echo "</td>"; 
							
					}
					?>
				<tr>
				</table>
			</div>
			<a href="item.php?do=Add" class="btn btn-primary">
				<i class="fa fa-plus"></i> New item
			</a>
		</div>
			 

										
					
					
	<?php				
 
		} elseif ($do == 'Add') {   ?>

                <h1 class="text-center">Add New Item</h1>
                <div class="category_container">
                    <form class="center form" action="?do=Insert" method="POST" enctype="multipart/form-data">
                        <!-- Start name Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Item name" />
                            </div>
                        </div>
                        <!-- End name Field -->
                        <!-- Start Description Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="Description" class="Description form-control"  autocomplete="off" placeholder="Item Description" />
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Description Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="Price" class="Description form-control"  autocomplete="off" placeholder="Item Price" />
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="Country" class="Description form-control"  autocomplete="off" placeholder="Item Country" />
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Status Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
                            </div>
                        </div>
					    <!-- End Status Field -->
                        <!-- Start Members Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Members</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="members">
                                    <option value="0">...</option>
                                    <?php
                                     $sql = "SELECT * FROM users";
                                     $stmt = $conn->prepare($sql);
                                     $stmt->execute();
                                     $data = $stmt->fetchAll();
                                     foreach($data as $arr){
                                     echo " <option value=" . $arr['UserID'] . ">" . $arr['username'] . "</option>";
                                     }
                                    ?>
                                </select>
                            </div>
                        </div>
					    <!-- End Members Field -->
                        <!-- Start Categories Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Categories</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="category">
                                    <option value="0">...</option>
                                    <?php
                                     $sql = "SELECT * FROM categories";
                                     $stmt = $conn->prepare($sql);
                                     $stmt->execute();
                                     $data = $stmt->fetchAll();
                                     foreach($data as $arr){
                                     echo " <option value=" . $arr['ID'] . ">" . $arr['Cat_Name'] . "</option>";
                                     }
                                    ?>
                
                                </select>
                            </div>
                        </div>
					    <!-- End Categories Field -->
                        <!-- Start Submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add item" class="btn btn-primary btn-lg" />
								</div>
							</div>
						<!-- End Submit Field -->
                 
<?php



		} elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $Description 	= $_POST['Description'];
                $Price 	        = $_POST['Price'];
                $Country 	    = $_POST['Country'];
                $name 	        = $_POST['name'];
                $status     	= $_POST['status'];
                $members     	= $_POST['members'];
                $category     	= $_POST['category'];
    
    
                // Validate The Form
    
                $formErrors = array();
    
    
                if (empty($Description)) {
                    $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
                }
    
                if (empty($Price)) {
                    $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
                }
    
                if (empty($Country)) {
                    $formErrors[] = 'Country Cant Be <strong>Empty</strong>';
                }
    
                if (empty($name)) {
                    $formErrors[] = 'name Cant Be <strong>Empty</strong>';
                }
                if (empty($status)) {
                    $formErrors[] = 'status Cant Be <strong>Empty</strong>';
                }
    
    
                // Loop Into Errors Array And Echo It
    
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
               
                
                if (empty($formErrors)) {
                    
                    $sql = "INSERT INTO items (Name, Description, Price, Country_Made, Status, Add_Date, Member_ID, Cat_ID) VALUES (:name, :desc, :price, :country,:status, now(), :member, :cat )";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        
                        'name' 	    => $name,
                        'desc' 	    => $Description,
                        'price' 	=> $Price,
                        'country' 	=> $Country,
                        'status' 	=> $status,
                        'member'    => $members,
                        'cat'        => $cat,
                    ]);
                    echo '<h1 class="text-center">Add New Member</h1>';
                    echo "<br>";
                    $theMsg = '<div class="alert alert-success text-center updated">Inserted successfully</div>';
                    redirectHome($theMsg,null);
                        

                };
                
            }else{
                $theMsg="you cant acess this page directly";
                redirectHome($theMsg,null);
            };
    
  

		} elseif ($do == 'Edit') { 
            if(isset($_GET["id"]) && is_numeric($_GET["id"]) ){
                $sql = "SELECT * FROM `items` WHERE `Item_ID`=? LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$_GET["id"]]); 
                $item_data = $stmt->fetchObject();
                if($item_data){
                ?>

                    <h1 class="text-center">Edit Item</h1>
                        <div class="category_container">
                            <form class="center form" action="?do=update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="item_id" value="<?php echo $item_data->Item_ID ?>" />
                                <!-- Start name Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Item name" value="<?php echo $item_data->Name ?>" />
                                    </div>
                                </div>
                                <!-- End name Field -->
                                <!-- Start Description Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Description" class="Description form-control"  autocomplete="off" placeholder="Item Description" value="<?php echo $item_data->Description ?>" />
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Price Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Price" class="Description form-control"  autocomplete="off" placeholder="Item Price" value="<?php echo $item_data->Price ?>" />
                                    </div>
                                </div>
                                <!-- End Price Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Country" class="Description form-control"  autocomplete="off" placeholder="Item Country"  value="<?php echo $item_data->Country_Made ?>" />
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Status Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="status">
                                            <option value="0" <?php if($item_data->Status == 0){echo "selected";};  ?>>...</option>
                                            <option value="1" <?php if($item_data->Status == 1){echo "selected";};  ?>>New</option>
                                            <option value="2" <?php if($item_data->Status == 2){echo "selected";};  ?>>Like New</option>
                                            <option value="3" <?php if($item_data->Status == 3){echo "selected";};  ?>>Used</option>
                                            <option value="4" <?php if($item_data->Status == 4){echo "selected";};  ?>>Very Old</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Status Field -->
                                <!-- Start Members Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Members</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="members">
                                            <?php
                                            $sql = "SELECT * FROM users";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $data = $stmt->fetchAll();
                                            foreach($data as $arr){
                                            echo " <option value=" . $arr['UserID'] ;
                                            if($item_data->Member_ID == $arr['UserID']){echo "selected";}; 
                                            echo ">" . $arr['username'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Members Field -->
                                <!-- Start Categories Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Categories</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="category">
                                            <?php
                                            $sql = "SELECT * FROM categories";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $data = $stmt->fetchAll();
                                            foreach($data as $arr){
                                            echo " <option value=" . $arr['ID'] ;
                                            if($item_data->Cat_ID == $arr['ID']){echo "selected";}; 
                                            echo ">" . $arr['Cat_Name'] . "</option>";
                                            }
                                            ?>
                        
                                        </select>
                                    </div>
                                </div>
                                <!-- End Categories Field -->
                                <!-- Start Submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                                        </div>
                                    </div>
						<!-- End Submit Field -->
<?php
                }
            }
	} elseif ($do == 'update') {
        echo '<h1 class="text-center Edit">Edit Item</h1>';
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Get data
            $id 	        = $_POST['item_id'];
			$name 	        = $_POST['name'];
			$Description 	= $_POST['Description'];
			$Price 	        = $_POST['Price'];
			$Country    	= $_POST['Country'];
			$status 	    = $_POST['status'];
			$members 	    = $_POST['members'];
			$category 	    = $_POST['category'];
           
            //validation
            $formErrors = array();
    
    
            if (empty($Description)) {
                $formErrors[] = 'Description Cant Be <strong>Empty</strong>';
            }

            if (empty($Price)) {
                $formErrors[] = 'Price Cant Be <strong>Empty</strong>';
            }

            if (empty($Country)) {
                $formErrors[] = 'Country Cant Be <strong>Empty</strong>';
            }

            if (empty($name)) {
                $formErrors[] = 'name Cant Be <strong>Empty</strong>';
            }
            if (empty($status)) {
                $formErrors[] = 'status Cant Be <strong>Empty</strong>';
            }


            // Loop Into Errors Array And Echo It

            foreach($formErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            //updating
            if(empty($formErrors)){
                $sql = "UPDATE `items` SET `Name`=?,`Description`=?,`Price`=?,`Country_Made`=?, `Status`=?,Cat_ID=? ,Member_ID=? WHERE `Item_ID`=? ";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name,$Description,$Price,$Country,$status,$category,$members,$id]);
                echo '<br><div class="alert alert-success text-center updated">Updated successfully</div>';
            };
        }else{
            echo "Invalid method";
        }



	}elseif($do == 'Delete'){
        echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$itemid = intval($_GET['id']);
				}else{
					$itemid = 0;
				}

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID ', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("DELETE FROM items WHERE Item_ID = :item");

					$stmt->bindParam(":item", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

    }elseif($do == 'Approve'){
        echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$itemid = intval($_GET['id']);
				}else{
					$itemid = 0;
				}

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("UPDATE items SET RegStatus=1 WHERE Item_ID=?");


					$stmt->execute([$itemid]);

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Items Approved</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID doesn\'t Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';
        
    }

		include "includes/templates/footer.php";

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>