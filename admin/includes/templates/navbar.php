<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="item.php">Items</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php">Members</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php">comments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add_admin.php">Add admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Logs</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           <?php echo $_SESSION["username"]; ?>
          </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item" href="members.php?do=Edit&id=<?php echo $_SESSION["id"]; ?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
