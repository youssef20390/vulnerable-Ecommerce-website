<?php
session_start();
if(isset($_SESSION["username"])){
    $pageTitle = "dashboard";
    include "init.php"; 


?>
<h1 class="text-center">Dashboard</h1>
<div class ="container home-stat text-center">
    <div class="row" >
        <div class="col-md-3">
            <div class="stat total-members" >
                Total members
                <span>
                   <a href="members.php"> <?php echo number_of_rows("UserId","users") ?>
                   </a>
                </span>

            </div>
        </div>
        <div class="col-md-3">
            <div class="stat pending-members" >
                Pending Members
                <span>
                   <a href="members.php?page=pending"><?php echo number_of_rows("RegStatus","users","RegStatus=0")?></a> 
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat total-items" >
                Total items
                <span>
                   <a href="item.php"><?php echo number_of_rows("Item_ID","items")?></a> 
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat total-comments" >
                Total comments
                <span>
                    20
                </span>
            </div>
        </div>
    </div>
</div>
<div class="latest_users">
<div class="card text-center">
    <div class="card-header">
        <i class="fa fa-users"></i> latest regeistered users
        <div class="card-body">
          <?php 
          $latest_users =  getLatestusers("username","users","UserID");
          foreach($latest_users as $user){
            echo $user['username'] . "<br>";
          }
          ?>
        </div>
    </div>
</div>
<div class="latest_items">
<div class="card text-center">
    <div class="card-header">
        <i class="fa fa-tag"></i> latest items
        <div class="card-body">
          <?php 
          $latest_items = getLatestitems("Name","items","Item_ID");
          foreach($latest_items as $item){
            echo $item['Name'] . "<br>";
          }
          ?>
        </div>
    </div>
</div>




<!-- <div class="container latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="card text-center">
                <div class="card-header">
                    <i class="fa fa-users"></i> latest regeistered users
                    <div class="card-body">
                        teest
                    </div>

                </div>

            </div>

        </div>

    </div>

</div> -->
<?php





    
    include "includes/templates/footer.php";
}else{
    header("location:index.php");
    exit();
};

?>







