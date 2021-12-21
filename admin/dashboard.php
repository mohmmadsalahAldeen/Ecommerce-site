<?php

ob_start(); // output buffering start

session_start();

if(isset($_SESSION['Username'])) {

  $pageTitle = 'Dashboard';

  include 'init.php' ;

  /* Start Dashboard page */

  $numUsers = 6; // Number of latest users

  $latestUsers = getLatest("*", "users", "ID_user", $numUsers); // Latest users Array

  $numItems = 6; // number of latest items

  $latestItems = getLatest("*", "items", "ID_item", $numItems); // Latest Items array

  $numComments = 4; // Number pf comments

  ?>
  <div class="home-stats">
    <div class="container text-center">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-md-3">
           <div class="stat st-members">
             <i class="fa fa-users"></i>
              <div class="info">
                Total Members
                <span>
                  <a href="members.php"><?php echo countItems('ID_user', 'users') ?></a>
                </span>
              </div>
           </div>
        </div>

        <div class="col-md-3">
           <div class="stat st-pending">
             <i class="fa fa-user-plus"></i>
             <div class="info">
               Pending Members
               <span><a href="members.php?do=Manage&page=Pending">
                 <?php echo checkItem("RegStatus", "users", 0) ?>
               </a></span>
             </div>
           </div>
        </div>

        <div class="col-md-3">
           <div class="stat st-items">
             <i class="fa fa-tag"></i>
             <div class="info">
               Total Items
               <span><a href="items.php"><?php echo countItems('ID_item', 'items') ?></a></span>
             </div>
           </div>
        </div>
        <div class="col-md-3">
           <div class="stat st-comments">
             <i class="fa fa-comments"></i>
             <div class="info">
                 Total Comments
                 <span>
                   <a href="comments.php"><?php echo countItems('ID_comment', 'comments') ?></a>
                 </span>
             </div>
           </div>
        </div>
      </div>
    </div>
 </div>

  <div class="latest">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-users"></i> Latest <?php  echo $numUsers; ?> Registerd users
              <span class="toggle-info pull-right">
                <i class="fa fa-plus fa-lg"></i>
              </span>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled latest-users">
               <?php
                 if (!empty($latestUsers)) {
                   foreach ($latestUsers as $user) {
                     echo '<li>';
                          echo $user['Username'];
                          echo '<a href="members.php?do=Edit&userid=' . $user['ID_user'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                     echo '<i class="fa fa-edit"></i>Edit';
                                     if ($user['RegStatus'] == 0) {

                                      echo " <a href='members.php?do=Activate&userid=". $user['ID_user'] ."' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Activate</a>";

                                     }
                                echo '</span>';
                          echo '</a>';
                     echo '</li>';
                   }
                 } else {
                   echo "There\'s no users to show";
                 }
               ?>
                </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-tag"></i> Latest <?php echo $numItems ?> items
              <span class="toggle-info pull-right">
                <i class="fa fa-plus fa-lg"></i>
              </span>
            </div>

            <div class="panel-body">
              <ul class="list-unstyled latest-users">
                 <?php
                     if(!empty($latestItems)) {
                         foreach ($latestItems as $item) {
                           echo '<li>';
                                echo $item['Name'];
                                echo '<a href="items.php?do=Edit&itemid=' . $item['ID_item'] . '">';
                                      echo '<span class="btn btn-success pull-right">';
                                           echo '<i class="fa fa-edit"></i>Edit';
                                           if ($item['approve'] == 0) {
                                            echo " <a href='items.php?do=approve&itemid=". $item['ID_item'] ."' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Approve</a>";
                                           }
                                      echo '</span>';
                                echo '</a>';
                           echo '</li>';
                         }
                   } else {
                     echo "There\'s no items to show";
                   }
                 ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

     <!-- Start latest comment -->
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-comments-o"></i>
              Latest <?php echo $numComments ?>  comments
              <span class="toggle-info pull-right">
                <i class="fa fa-plus fa-lg"></i>
              </span>
            </div>
            <div class="panel-body">
              <?php
                $stmt = $con->prepare("SELECT
                                            comments.*, users.Username AS Uname
                                       FROM
                                            comments
                                       INNER JOIN
                                            users
                                       ON
                                            users.ID_user = comments.ID_user
                                       ORDER BY
                                            ID_comment DESC
                                       LIMIT
                                            $numComments");
                $stmt->execute();
                $comments = $stmt->fetchAll();

                if (!empty($comments)) {
                      foreach ($comments as $comment) {
                        echo '<div class="comment-box">';
                            echo '<span class="member-n">
                              <a href="members.php?do=Edit&userid=' .$comment['ID_user'] .'">
                              '. $comment['Uname'] . '</a></span>';
                            echo '<p class="member-c">' . $comment['comment'] . '</p>';
                        echo '</div>';
                      }

              } else {
                echo "There\'s no comments to show";
              }
              ?>

            </div>
          </div>
        </div>
      </div>
       <!-- End latest comment -->
    </div>
  </div>

  <?php
  /* End Dashboard page */

  include  $tpl . 'footer.php';

} else {

  header('Location: index.php');

  exit();
}

ob_end_flush(); // Release the output
?>
