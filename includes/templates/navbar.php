<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Logs</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(isset($_SESSION['user'])){echo $_SESSION['user'];if(checkuserstatus($_SESSION['user']) == 1 ){echo "(Not Activated)";} }else{echo 'Categories';} ?>
          </a>
          <ul class="dropdown-menu navbar-right ">
            <?php
              $Cats = getcats();
              foreach($Cats as $cat){
                echo "<li><a class='dropdown-item' href=categories.php?pageid=" . $cat['ID'] . "&pagename=". $cat['Cat_Name'] . ">" . $cat['Cat_Name'] . "</a></li>";

              }
            
            
            ?>

            
            <li><hr class="dropdown-divider"></li>
            <?php if(isset($_SESSION['user'])){  ?>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            <?php  }else{?>
            <li><a class="dropdown-item" href="login.php">sign in</a></li>
            <li><a class="dropdown-item" href="login.php">sign up</a></li>
            <?php   }; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->