<?php
  session_start();
  $noNavbar = '';
  $pageTitle = 'Login';

  if (isset($_SESSION['Username'])) {
    header('Location: dashboard.php');
  }
  include 'init.php';

  // check if the user coming from http post request

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['user'];
    $password = $_POST['pass'];
    //$hashedPass = sha1($password);

    // check if the user exist in database

    $stmt = $con->prepare("SELECT ID_user, Username, Password FROM users WHERE Username = '$username' AND Password = '$password' AND GroupID = 1 LIMIT 1");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    // if count > 0 this main the database contain record about this Username

    if($count > 0) {
      $_SESSION['Username'] = $username; // register session name

      $_SESSION['ID_user'] = $row['ID_user'];  // Register session ID

      header('Location: dashboard.php'); // redirect to dashboard page
      exit();
    }

  }

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <h4 class="text-center">Admin Login</h4>
  <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
  <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
  <input class="btn btn-lg btn-primary btn-block" type="submit" value="login" />
</form>

<?php

  include  $tpl . 'footer.php';

?>
