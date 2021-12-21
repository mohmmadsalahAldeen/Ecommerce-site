<?php

// Manage comments page

ob_start(); // output buffering start

session_start();

$pageTitle = 'Comments';

if (isset($_SESSION['Username'])) {

  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  // start manage page

  if($do == 'Manage') { // Manage memers page

    // Select all users except admin

    $stmt = $con->prepare("SELECT
                               comments.*, items.Name AS Iname , users.Username AS Uname
                           FROM
                               comments
                          INNER JOIN
                               items
                          ON
                             items.ID_item = comments.ID_item
                          INNER JOIN
                            users
                          ON
                            users.ID_user = comments.ID_user
                          ORDER BY
                            ID_comment DESC");

    // Execute the statement

    $stmt->execute();

    // Assign to variable

    $comments = $stmt->fetchAll();

    if (!empty($comments)) {

    ?>

    <h1 class="text-center">Manage comments</h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>ID</td>
            <td>Comment</td>
            <td>Item name</td>
            <td>User name</td>
            <td>Added date</td>
            <td>Control</td>
          </tr>
         <?php
            foreach ($comments as $comment) {
              echo "<tr>";
                  echo "<td>" . $comment['ID_comment']   . "</td>";
                  echo "<td>" . $comment['comment'] . "</td>";
                  echo "<td>" . $comment['Iname']    . "</td>";
                  echo "<td>" . $comment['Uname'] . "</td>";
                  echo "<td>" . $comment['comment_date']     ."</td>";
                  echo "<td>
                       <a href='comments.php?do=Edit&comid=". $comment['ID_comment']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                       <a href='comments.php?do=Delete&comid=". $comment['ID_comment'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                       if ($comment['status'] == 0) {

                        echo " <a href='comments.php?do=Approve&comid=". $comment['ID_comment'] ."' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";

                       }
                      echo "</td>";
              echo "</tr>";
            }
         ?>
          <tr>
        </table>
      </div>
    </div>

  <?php } else {

    echo "<div class='container'>";
        echo "<div class='nice-message'>There\'s no comments to show</div>";
    echo "<div>";
  } ?>

  <?php
    } elseif ($do == 'Edit') { // Edit page

    //check if get request comid is numeric & get the integer value of It

    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

    // Select all data depend on this ID

    $stmt = $con->prepare("SELECT * FROM comments WHERE ID_comment = '$comid' ");

    // Execute query

    $stmt->execute(array($comid));

    // fetch the data

    $row = $stmt->fetch();

    // The row count

    $count = $stmt->rowCount();

    // if there's such id the form

    if ($count > 0) { ?>

    <h1 class="text-center">Edit comments</h1>

    <div class="container">
      <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="comid" value="<?php echo $comid ?>" />
        <!-- Start comment field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Comment</label>
          <div class="col-sm-10 col-md-4">
            <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
          </div>
        </div>
        <!-- End comment field -->
        <!-- Start Submit field -->
        <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="save" class="btn btn-primary btn-lg" />
          </div>
        </div>
        <!-- End Submit field -->
      </form>

    </div>

  <?php

   // if there's no such show error message

    } else {

      echo "<div class='container'>";

      $theMsg = "<div class='alert alert-danger'>Theres no such ID</div>";

      redirectHome($theMsg);

      echo "</div>";

    }

 } elseif ($do == 'Update') { // Update page

  echo "<h1 class='text-center'>Update comment</h1>";
  echo "<div class='container'>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get variables from the form

    $comid    = $_POST['comid'];
    $comment  = $_POST['comment'];

    // Update the database with this info

   $stmt = $con->prepare("UPDATE
                              comments
                          SET
                              comment = '$comment'
                          WHERE
                              ID_comment = '$comid'
                              ");

   $stmt->execute(array($comid, $comment));

   // echo success message

   $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

   redirectHome($theMsg, 'back');

  } else {

    $theMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";

    redirectHome($theMsg);
  }

  echo "</div>";

} elseif ($do == 'Delete') { // Delete comment page

  echo "<h1 class='text-center'>Delete comments </h1>";
  echo "<div class='container'>";

     //check if get request userid is numeric & get the integer value of It

     $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

     // Select all data depend on this ID

     $check = checkItem('ID_comment', 'comments', $comid);

     // if there's such id show the form

     if ($check > 0) {

         $stmt = $con->prepare("DELETE FROM comments WHERE ID_comment = :zcomid ");

         $stmt->bindParam(":zcomid", $comid);

         $stmt->execute();

         $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() .' Record Deleted</div>';

         redirectHome($theMsg, 'back');

     } else {
       $theMsg = '<div class="alert alert-danger">this is is not exist</div>';

       redirectHome($theMsg);

     }

 echo "</div>";

} elseif ($do == 'Approve') {

     echo "<h1 class='text-center'>Approve comments </h1>";
     echo "<div class='container'>";

     //check if get request comid is numeric & get the integer value of It

     $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

     // Select all data depend on this ID

     $check = checkItem('ID_comment', 'comments', $comid);

     // if there's such id show the form

     if ($check > 0) {

         $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE ID_comment = '$comid'");

         $stmt->execute(array($comid));

         $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() .' Record approved</div>';

         redirectHome($theMsg, 'back');

     } else {
       $theMsg = '<div class="alert alert-danger">this is is not exist</div>';

       redirectHome($theMsg);

     }

 echo "</div>";

}

  include $tpl . 'footer.php';

} else {

  header('Location: index.php');

  exit();
}

ob_end_flush();
?>
