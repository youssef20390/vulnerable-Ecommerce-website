<?php
session_start();
?>
<?php include "init.php"; ?>
<div class="user_category_container">
   <h1 class="text-center"><?php echo htmlspecialchars(str_replace('_',' ',$_GET['pagename']));  ?></h1>
   <div class="row">
      <?php
      $catID = $_GET['pageid'];
      $items = getitems("Cat_ID",$catID);
      foreach($items as $item){
         echo "<div class='col-sm-4 col-md-2 '>";
            echo "<div class='card'>";
               echo "<img src='https://img.freepik.com/free-icon/user_318-159711.jpg' alt='No image'>";
               echo "<div class='caption'>";
                  echo "<h3>" . $item['Name'] . "<h3>";
                  echo "<p>" .  $item['Description'] . "<p>";
                  echo "<h5>" .  $item['Price'] . "<h5>";
               echo "</div>";
            echo "</div>";
         echo "</div>";


      }

      ?>
   </div>

</div>



<?php include "includes/templates/footer.php";  ?>

