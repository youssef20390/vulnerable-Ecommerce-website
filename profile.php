<?php
$pageTitle = "Profile";
$NonewCss= "";
session_start();
?>
<?php include "init.php"; ?>
<?php if(isset($_SESSION['user'])){  ?>

<?php 
$userdata = getusers_by_id($_GET["id"]);
?>

<?php echo  "<div class='text-center '><p class='profile-title'>Welcome " . $userdata->username . "</p></div>"  ?>
<div class="card profile-card ">
  <div class="card-header">
    My Information
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p>Name : <?php echo $userdata->username; ?></p>
      <p>Email  : <?php echo $userdata->Email ; ?></p>
      <p>GroupID : <?php echo $userdata->GroupID; ?></p>
      <p>Date : <?php echo $userdata->Date; ?></p>
      <p>RegStatus : <?php echo $userdata->RegStatus; ?></p>
      <p>TrustStatus : <?php echo $userdata->TrustStatus; ?></p>
      <p>UserID : <?php echo $userdata->UserID; ?></p>
      <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
    </blockquote>
  </div>
</div>
<div class="card profile-card ">
  <?php $usersADS = getitems('Member_ID',$_SESSION["user_id"] )  ?>
  <div class="card-header">
    ADS
  </div>
  <div class="card-body">
    
      
  <?php foreach($usersADS as $usersAD){
         echo "<div class='col-sm-6 col-md-3 user-card' style='display: inline-block; vertical-align: top;'>"; // add inline style
            echo "<div class='card '>";
               echo "<img src='https://img.freepik.com/free-icon/user_318-159711.jpg' alt='No image'>";
               echo "<div class='caption'>";
                  echo "<h3>" . $usersAD['Name'] . "<h3>";
                  echo "<p>" .  $usersAD['Description'] . "<p>";
                  echo "<h5>" .  $usersAD['Price'] . "<h5>";
               echo "</div>";
            echo "</div>";
         echo "</div>";
        }
         ?>
      
      <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
    
  </div>
</div>
<div class="card profile-card ">
  <div class="card-header">
    ADS
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p>A well-known quote, contained in a blockquote element.</p>
      <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
    </blockquote>
  </div>
</div>
<?php }else{
  header('location:login.php');

}  
?>


<?php include "includes/templates/footer.php";  ?>
