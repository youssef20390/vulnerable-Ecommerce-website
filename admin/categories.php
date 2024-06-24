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
            $sql = "SELECT * FROM categories";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$categories = $stmt->fetchAll();
			

?>
<a href="categories.php?do=Add" class="btn btn-primary float-end">
	<i class="fa fa-plus"></i> New category
</a>
<h1 class="text-center">Manage categories</h1>
<div class="card w-50 category_card block" style="width: 18rem;">
  <div class="card-header">
    Categories
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
	<?php 
	foreach($categories as $category){
	  echo "<div class='cat'>";
	    	echo "<div class='hidden-buttons'>";
				echo "<a href=?do=Edit&id=" . $category['ID'] . " class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
				echo "<a href=?do=Delete&id=" . $category['ID'] . " class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
			echo "</div>";
			echo"<div>";
			echo  "<h3>" . $category['Cat_Name'] . "</h3>";
			echo	"<br>";
			echo 	"Description=> " 	. $category['Description'] ."<br>";
			echo 	"Ordering=> " 		. $category['Ordering']."<br>";
			echo 	"Visibility=>"		; 
			if($category['Visibility'] == 1){echo "Hidden";}else{echo "Visible";};
			echo "<br>";
			echo  "Allow_Comment=>" 	; 
			if($category['Allow_Comment'] == 1){echo "Comments disabled";}else{echo "Comments Allowed";};
			echo "<br>";
			echo  "Allow_Ads=>"		;
			if($category['Allow_Ads'] == 1){echo "Ads is disabled";}else{echo "Ads is active ";};
			echo "<br>";
			echo "<hr>";
			echo"</div>";
	 echo"</div>";
	}
	?>
	</li>
	
  </ul>
  
</div>



<?php
		} elseif ($do == 'Add') {            
?>
          <h1 class="text-center">Add New category</h1>
			<div class="category_container">
				<form class="center form" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Category name" />
						</div>
					</div>
					<!-- End name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="Description" class="Description form-control"  autocomplete="off" placeholder="Category Description" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="Ordering" class="form-control" required="required" placeholder="Ordering" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- Start visibility Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
                                <input type="radio" name="visibility" id="vis-yes" value="0" checked>
                                <label for="vis-yes">Yes</label>
                            </div>
							<div>
                                <input type="radio" name="visibility" id="vis-no" value="1" >
                                <label for="vis-no">No</label>
                            </div>
						</div>
					</div>
					<!-- End visibility Field -->
					<!-- Start commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow comments</label>
						<div class="col-sm-10 col-md-6">
							<div>
                                <input type="radio" name="commenting" id="com-yes" value="0" checked>
                                <label for="com-yes">Yes</label>
                            </div>
							<div>
                                <input type="radio" name="commenting" id="com-no" value="1" >
                                <label for="vcomis-no">No</label>
                            </div>
						</div>
					</div>
					<!-- End commenting Field -->
					<!-- Start Ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
                                <input type="radio" name="Ads" id="Ads-yes" value="0" checked>
                                <label for="Ads-yes">Yes</label>
                            </div>
							<div>
                                <input type="radio" name="Ads" id="Ads-no" value="1" >
                                <label for="Ads-no">No</label>
                            </div>
						</div>
					</div>
					<!-- End commenting Field -->
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


		} elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name 	        = $_POST['name'];
                $Description 	= $_POST['Description'];
                $Ordering 	    = $_POST['Ordering'];
                $visibility 	= $_POST['visibility'];
                $commenting 	= $_POST['commenting'];
                $Ads 	        = $_POST['Ads'];
    
                
    
                // Validate The Form
    
                $formErrors = array();
    
                if (empty($name)) {
                    $formErrors[] = 'Name Cant Be <strong>Empty</strong>';
                }
    
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                $check = checkItem("Cat_Name","categories",$name);

                if($check == 1 ){
                    echo "<div class='alert alert-danger text-center' >This category name already exist </div>";
                
                }else{
                    if (empty($formErrors)) {
                        
                        $sql = "INSERT INTO categories (Cat_Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES (:name, :desc, :order, :vis, :comm, :ads )";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            
                            'name'  	=> $name,
                            'desc' 	    => $Description,
                            'order' 	=> $Ordering,
                            'vis'   	=> $visibility,
                            'comm'  	=> $commenting,
                            'ads' 	    => $Ads,
                        ]);
                        echo '<h1 class="text-center">Add New Category</h1>';
                        echo '<br><div class="alert alert-success text-center updated">Inserted successfully</div>';
                            
    
                    }
                };
            }else{
                $theMsg="you cant acess this page directly";
                redirectHome($theMsg,null);
               }
    



		} elseif ($do == 'Edit') {
			if(isset($_GET["id"]) && is_numeric($_GET["id"]) ){
				$sql = "SELECT * FROM `categories` WHERE `ID`=? LIMIT 1";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$_GET["id"]]);
				$data = $stmt->fetchObject();
				if($data){
					// var_dump($data);
?>
						
					<h1 class="text-center">Edit category</h1>
					<div class="category_container">
						<form class="center form" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $data->ID ?>" />
							<!-- Start name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="name" class="form-control"  required="required" placeholder="Category name" value="<?php echo $data->Cat_Name ;?>" />
								</div>
							</div>
							<!-- End name Field -->
							<!-- Start Description Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="Description" class="Description form-control"  placeholder="Category Description" value="<?php echo $data->Description ;?>" />
								</div>
							</div>
							<!-- End Description Field -->
							<!-- Start Ordering Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Ordering</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="Ordering" class="form-control" required="required" placeholder="Ordering" value="<?php echo $data->Ordering ;?>" />
								</div>
							</div>
							<!-- End Ordering Field -->
							<!-- Start visibility Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Visible</label>
								<div class="col-sm-10 col-md-6">
									<div>
										<input type="radio" name="visibility" id="vis-yes" value="0" <?php if($data->Visibility == 0){echo "checked";};  ?>>
										<label for="vis-yes">Yes</label>
									</div>
									<div>
										<input type="radio" name="visibility" id="vis-no" value="1"  <?php if($data->Visibility == 1){echo "checked";};?> >
										<label for="vis-no">No</label>
									</div>
								</div>
							</div>
							<!-- End visibility Field -->
							<!-- Start commenting Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Allow comments</label>
								<div class="col-sm-10 col-md-6">
									<div>
										<input type="radio" name="commenting" id="com-yes" value="0"  <?php if($data->Allow_Comment == 0){echo "checked";};  ?>>
										<label for="com-yes">Yes</label>
									</div>
									<div>
										<input type="radio" name="commenting" id="com-no" value="1"  <?php if($data->Allow_Comment == 1){echo "checked";};?>>
										<label for="vcomis-no">No</label>
									</div>
								</div>
							</div>
							<!-- End commenting Field -->
							<!-- Start Ads Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Allow Ads</label>
								<div class="col-sm-10 col-md-6">
									<div>
										<input type="radio" name="Ads" id="Ads-yes" value="0"  <?php if($data->Allow_Ads == 0){echo "checked";};  ?>>
										<label for="Ads-yes">Yes</label>
									</div>
									<div>
										<input type="radio" name="Ads" id="Ads-no" value="1" <?php if($data->Allow_Ads == 1){echo "checked";};  ?>>
										<label for="Ads-no">No</label>
									</div>
								</div>
							</div>
							<!-- End commenting Field -->
							<br>
							<!-- Start Submit Field -->
							<div class="form-group form-group-lg">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Update category" class="btn btn-primary btn-lg" />
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
	
	 


		} elseif ($do == 'Update') {
			echo '<h1 class="text-center Edit">Edit Member</h1>';
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//Get data
				$id 	= $_POST['id'];
				$name 	= $_POST['name'];
				$description 	= $_POST['Description'];
				$ordering 	= $_POST['Ordering'];
				$vis 	= $_POST['visibility'];
				$comm 	= $_POST['commenting'];
				$ads 	= $_POST['Ads'];
				
				
				//validation
				$check = checkItem("ID","categories",$id );
				//updating
				if($check > 0){
					$sql = "UPDATE `categories` SET `Cat_Name`=?,`Description`=?,`Ordering`=?,`Visibility`=?,`Allow_Comment`=?,`Allow_Ads`=? WHERE `ID`=? ";
					$stmt = $conn->prepare($sql);
					$stmt->execute([$name,$description,$ordering,$vis,$comm,$ads,$id]);
					echo '<br><div class="alert alert-success text-center updated">Updated successfully</div>';	
				};

			}else{
				echo "Invalid method";
			}


		} elseif ($do == 'Delete') {
			echo "<h1 class='text-center'>Delete category</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				if(isset($_GET['id']) && is_numeric($_GET['id'])){
					$catid = intval($_GET['id']);
				}else{
					$catid = 0;
				}

				// Select All Data Depend On This ID

				$check = checkItem("ID","categories",$catid );

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $conn->prepare("DELETE FROM categories WHERE ID = :zuser");

					$stmt->bindParam(":zuser", $catid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

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