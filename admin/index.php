<?php
$nonavbar = "";
$pageTitle = "Login";
session_start();
if(isset($_SESSION["username"])){
    header("location:dashboard.php");
    exit();
};
?>
<?php include "init.php"; ?>

  <div class="card w-50" >
    <div class="card-header">
      <h4 class="text-center">Admin Login</h4>
    </div>
    <div class="card-body">
        <?php if(isset($_SESSION["Error"])){  ?>
        <div class="alert alert-danger text-center">
            <?php echo $_SESSION["Error"]; ?>
        </div>
        <?php };
              unset($_SESSION["Error"]);       
        ?>
        <?php if(isset($_SESSION["missing_data"])){  ?>
        <div class="alert alert-danger text-center">
            <?php echo $_SESSION["missing_data"]; ?>
        </div>
        <?php };
              unset($_SESSION["missing_data"]);       
        ?>
      <form action="includes/logic/loginLogic.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>

 







<?php include "includes/templates/footer.php";  ?>






