<?php

// Paths
$css = "layout/css/";
$js = "layout/js/";








//inccludes
include "includes/functions/functions.php";
include "includes/templates/header.php";
include "conn.php";
include "includes/languages/english.php";
if(!isset($nonavbar)){
  include "includes/templates/navbar.php";
}


