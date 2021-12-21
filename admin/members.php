<?php

ob_start(); // output buffering start

session_start();

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {

  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  // start manage page

  if($do == 'Manage') { // Manage memers page

    $query = '';

    if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

      $query = 'AND RegStatus = 0';

    }

    // Select all users except admin

    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY ID_user DESC");

    // Execute the statement

    $stmt->execute();

    // Assign to variable

    $rows = $stmt->fetchAll();

    if (!empty($rows)) {

  ?>

    <h1 class="text-center">Manage member</h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Email</td>
            <td>Full name</td>
            <td>Registerd date</td>
            <td>Control</td>
          </tr>
         <?php
            foreach ($rows as $row) {
              echo "<tr>";
                  echo "<td>" . $row['ID_user']   . "</td>";
                  echo "<td>" . $row['Username'] . "</td>";
                  echo "<td>" . $row['Email']    . "</td>";
                  echo "<td>" . $row['FullName'] . "</td>";
                  echo "<td>" . $row['Date']     ."</td>";
                  echo "<td>
                       <a href='members.php?do=Edit&userid=". $row['ID_user']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                       <a href='members.php?do=Delete&userid=". $row['ID_user'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                       if ($row['RegStatus'] == 0) {

                        echo " <a href='members.php?do=Activate&userid=". $row['ID_user'] ."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
                       }
                      echo "</td>";
              echo "</tr>";
            }
         ?>
           <tr>
        </table>
      </div>
       <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add new member</a>
    </div>

 <?php  } else {

   echo "<div class='container'>";
       echo "<div class='nice-message'>There\'s no record to show</div>";
       echo "<a href='members.php?do=Add' class='btn btn-primary'>
              <i class='fa fa-plus'></i> Add new member
       </a>";
   echo "</div>";
 } ?>

  <?php } elseif ($do == 'Add') { //Add memebers page ?>

    <h1 class="text-center">Add new Member</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
        <!-- Start Username field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="username" class="form-control" required = "required" autocomplete="off" placeholder="Username to login into shop"/>
          </div>
        </div>
        <!-- End Username field -->
        <!-- Start Password field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10 col-md-4">
               <input type="password" name="password" class="password form-control" required = "required" autocomplete="new-password" data-text="leave blank if you dont want to change" placeholder="password must be hard and & complex" />
               <i class="show-pass fa fa-eye fa-2x"></i>
          </div>
        </div>
        <!-- End Password field -->
        <!-- Start Email field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10 col-md-4">
               <input type="email" name="email" class="form-control" required = "required" placeholder="Email must be valid"/>
          </div>
        </div>
        <!-- End Email field -->
        <!-- Start Full name field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Full name</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="full" class="form-control" required = "required" placeholder="Full name appear in your profile page"/>
          </div>
        </div>
        <!-- End Full name field -->
		<!-- Start avatar field -->
		<div class="form-group form-group-lg">
		     <label class="col-sm-2 control-label">User avatar</label>
		     <div class="col-sm-10 col-md-4">
			    <input type="file" name="avatar" class="form-control" required="required" placeholder=""/>
			 </div>
		</div>
		<!-- End avatar field -->
        <!-- Start Submit field -->
        <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="Add member" class="btn btn-primary btn-lg" />
          </div>
        </div>
        <!-- End Submit field -->
      </form>
    </div>

 <?php
    } elseif ($do == 'Insert') {

      // insert member page

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        echo "<h1 class='text-center'>Insert member</h1>";
        echo "<div class='container'>";
		
		// Upload variables 
		
		$avatarName = $_FILES['avatar']['name'];
		$avatarSize = $_FILES['avatar']['size'];
		$avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarType = $_FILES['avatar']['type'];		
		
		// List of allowed file typed to upload
		
		$avatarExtension = array("jpeg", "jpg", "png", "gif");

        // Get variables from the form

        $user  = $_POST['username'];
        $pass  = $_POST['password'];
        $email = $_POST['email'];
        $name  = $_POST['full'];

        $hashPass = sha1($_POST['password']);

         // Validate the form

         $formErrors = array();

         if (strlen($user) < 4) {
           $formErrors[] = 'username cant be less than 4 characters';
         }

         if (strlen($user) > 20) {
           $formErrors[] = 'username cant be more than 20 characters';
         }

         if (empty($user)) {
           $formErrors[] = 'Username cant be empty';
         }

         if (empty($pass)) {
           $formErrors[] = 'Password cant be empty';
         }

         if (empty($name)) {
           $formErrors[] = 'Full name cant be empty';
         }

         if (empty($email)) {
           $formErrors[] = 'Email cant be empty';
         }

         // loop into errors array echo interface

         foreach ($formErrors as $error) {
           echo '<div class="alert alert-danger">' . $error . '</div>';
         }
        /*
         // check if there's no errors proceed the update operation

         if (empty($formErrors)) {

           // check if user exist in database

           $check = checkItem("Username", "users", $user);

           if ($check == 1) {

             $theMsg = '<div class="alert alert-danger">sorry this user is exist</div>';

             redirectHome($theMsg,'back');

           } else {

             // Insert userinfo in database

             $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, Date) VALUES(:zuser, :zpass, :zmail, :zname, now()) ");

             $stmt->execute(array(

               'zuser' => $user,
               'zpass' => $hashPass,
               'zmail' => $email,
               'zname' => $name
             ));

             // echo success message

             $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted</div>';

             redirectHome($theMsg, 'back');

           }

         }
		 */

      } else {

        echo '<div class="container">';

        $theMsg = "<div class='alert alert-danger'>sorry you cant browse this page directly</div>";

        redirectHome($theMsg);

        echo "</div>";

      }

      echo "</div>";

    } elseif ($do == 'Edit') { // Edit page

    //check if get request userid is numeric & get the integer value of It

    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    // Select all data depend on this ID

    $stmt = $con->prepare("SELECT * FROM users WHERE ID_user = '$userid' LIMIT 1");

    // Execute query

    $stmt->execute(array($userid));

    // fetch the data

    $row = $stmt->fetch();

    // The row count

    $count = $stmt->rowCount();

    // if there's such id the form

    if ($count > 0) { ?>

    <h1 class="text-center">Edit Member</h1>

    <div class="container">
      <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
        <!-- Start Username field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required"/>
          </div>
        </div>
        <!-- End Username field -->
        <!-- Start Password field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10 col-md-4">
               <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
               <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave blank if you want to change" data-text="leave blank if you dont want to change" />
          </div>
        </div>
        <!-- End Password field -->
        <!-- Start Email field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10 col-md-4">
               <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required"/>
          </div>
        </div>
        <!-- End Email field -->
        <!-- Start Full name field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Full name</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>" required="required"/>
          </div>
        </div>
        <!-- End Full name field -->
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

  echo "<h1 class='text-center'>Update member</h1>";
  echo "<div class='container'>";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get variables from the form

    $id    = $_POST['userid'];
    $user  = $_POST['username'];
    $email = $_POST['email'];
    $name  = $_POST['full'];

     // Password trick

     // condition ? true : false

     $pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = $_POST['newpassword'];

     // Validate the form

     $formErrors = array();

     if (strlen($user) < 4) {
       $formErrors[] = 'username cant be less than 4 characters';
     }

     if (strlen($user) > 20) {
       $formErrors[] = 'username cant be more than 20 characters';
     }

     if (empty($user)) {
       $formErrors[] = 'Username cant be empty';
     }

     if (empty($name)) {
       $formErrors[] = 'Full name cant be empty';
     }

     if (empty($email)) {
       $formErrors[] = 'Email cant be empty';
     }

     // loop into errors array echo interface

     foreach ($formErrors as $error) {
       echo '<div class="alert alert-danger">' . $error . '</div>';
     }

     // check if there's no errors proceed the update operation

     if (empty($formErrors)) {

         $stmt2 = $con->prepare("SELECT
                                      *
                                 FROM
                                      users
                                 WHERE
                                      Username = '$user'
                                 AND
                                      ID_user != '$id'
                                 ");

         $stmt2->execute(array($id, $user));

         $count = $stmt2->rowCount();

         if ($count == 1) {

           echo "<div class='alert alert-danger'>Sorry this user is exist</div>";

           redirectHome($theMsg, 'back');

         } else {

            // Update the database with this info

            $stmt = $con->prepare("UPDATE
                                       users
                                   SET
                                       Username = '$user' ,
                                       Email    = '$email',
                                       FullName = '$name' ,
                                       Password = '$pass'
                                   WHERE
                                       ID_user = '$id'
                                       ");
            $stmt->execute(array($id, $user, $email, $name, $pass));

            // echo success message

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

            redirectHome($theMsg, 'back');

         }

     }

  } else {

    $theMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";

    redirectHome($theMsg);
  }

  echo "</div>";

} elseif ($do == 'Delete') { // Delete member page

  echo "<h1 class='text-center'>Delete member </h1>";
  echo "<div class='container'>";

     //check if get request userid is numeric & get the integer value of It

     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

     // Select all data depend on this ID

     $check = checkItem('ID_user', 'users', $userid);

     // if there's such id show the form

     if ($check > 0) {

         $stmt = $con->prepare("DELETE FROM users WHERE ID_user = :zuser ");

         $stmt->bindParam(":zuser", $userid);

         $stmt->execute();

         $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() .' Record Deleted</div>';

         redirectHome($theMsg, 'back');

     } else {
       $theMsg = '<div class="alert alert-danger">this is is not exist</div>';

       redirectHome($theMsg);

     }

 echo "</div>";

} elseif ($do == 'Activate') {

     echo "<h1 class='text-center'>Activate member </h1>";
     echo "<div class='container'>";

     //check if get request userid is numeric & get the integer value of It

     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

     // Select all data depend on this ID

     $check = checkItem('ID_user', 'users', $userid);

     // if there's such id show the form

     if ($check > 0) {

         $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE ID_user = '$userid'");

         $stmt->execute(array($userid));

         $theMsg = "<div class='alert alert-success'>". $stmt->rowCount() .' Record Updated</div>';

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
