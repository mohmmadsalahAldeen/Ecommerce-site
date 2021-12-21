<?php

  // Error reporting

  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  include 'admin/connect.php';

  $sessionUser = '';
  if(isset($_SESSION['user'])) {
    $sessionUser = $_SESSION['user'];
  }

  // Routes

  $tpl  = 'includes/templates/'; // Templates directory
  $lang = 'includes/languages/'; // languages dicrectory
  $func = 'includes/functions/'; // Functions directory
  $css  = 'layout/css/'; // css directory
  $js   = 'layout/js/'; // JS direcory

  // Include the important

  include $func . 'functions.php';
  include $lang . 'english.php'  ;
  include $tpl  . 'header.php'   ;

?>
