<?php
session_start();
if(isset($_SESSION["username"])){
    $pageTitle = "dashboard";
    include "init.php"; 


?>
<h1 class="text-center">Add admin</h1>
<div class="category_container">
    <form class="center form" action="includes/logic/signupLogic.php" method="POST" >
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="logemail" class="Description form-control"  autocomplete="off" placeholder="Email"  />
        </div>
    </div>
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="logpass" class="Description form-control"  autocomplete="off" placeholder="Password"  />
        </div>
    </div>
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Full Name</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="logname" class="Description form-control"  autocomplete="off" placeholder="Name"  />
        </div>
    </div>
    <?php 
    echo "<br>" ;
    echo "<br>" ;
    ?>
    <input type="submit" value="Add" class="btn btn-primary btn-lg" />
    </form>
</div>


<?php





    
    include "includes/templates/footer.php";
}else{
    header("location:index.php");
    exit();
};

?>







