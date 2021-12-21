<?php

/*

  Categories => [ Manage | Edit | Update | Add | Insert | Delete | Status ]

*/

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

// if the page is main page

if ($do == 'Manage') {

  echo 'welcome you are in manage category page';
  echo '<a href="?do=Insert">Add new Category +</a>'

} elseif($do == 'Add') {

  echo 'Welcome you are in add category page';

} elseif ($do == 'Insert') {

  echo 'Welcome you are in insert category page';

} else {
  echo 'Error there\'s No page with this name ';
}

?>
