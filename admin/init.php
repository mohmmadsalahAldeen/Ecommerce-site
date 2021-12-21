<?php

  include 'connect.php';

  // Routes

  $tpl  = 'includes/templates/'; // templates directory
  $lang = 'includes/languages/'; // languages dicrectory
  $func = 'includes/functions/'; // Functions directory
  $css  = 'layout/css/'; // css directory
  $js   = 'layout/js/'; // JS direcory

  // include the important

  include $func . 'functions.php';
  include $lang . 'english.php';
  include $tpl  . 'header.php';

  // include navbar on all pages expect the one with $noNavbar variable

  if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }


?>
