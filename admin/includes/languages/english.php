<?php

function lang( $phrase ) {

  static $lang = array(

   // NAVBAR LINKS

    'HOME_ADMIN'   => 'Home',
    'CATEGORIES'   => 'Categories',
    'ITEMS'        => 'Items',
    'MEMBERS'      => 'Members',
    'COMMENTS'     => 'Comments',
    'STATISTICS'   => 'Statistics',
    'LOGS'         => 'Logs',
    'EDIT_PROFILE' => 'Edit profile',
    'SETTINGS'     => 'Settings',
    'LOGOUT'       => 'Logout',
    'VISIT_SHOP'   => 'Visit shop'

  );

  return $lang[$phrase];
}

?>
