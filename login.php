<?php
ob_start();


  session_start();
  $pageTitle = 'Login';

  if (isset($_SESSION['user'])) {
    header('Location: index.php');
  }
  include "init.php";

  // Check if user coming from http post request

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {

    $user = $_POST['username'];
    $pass = $_POST['password'];
    //$hashedPass = sha1($pass);

    // Check if the user exist in database

    $stmt = $con->prepare("SELECT
                                ID_user, Username, Password
                           FROM
                                users
                           WHERE
                                Username = ?
                           AND
                                Password = ?");

    $stmt->execute(array($user, $pass));

    $get = $stmt->fetch();

    $count = $stmt->rowCount();

    // If count > 0 this mean the database contain record about this username

    if ($count > 0) {

      $_SESSION['user'] = $user; // Register session name

      $_SESSION['IDu']  = $get['ID_user']; // Register user id in session 

      header('Location: index.php'); // Redirect to index page

      exit();
    }

  } else {

      $formErrors= array();

      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2= $_POST['password2'];
      $email    = $_POST['email'];

      if (isset($username)) {

        $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);

        if (strlen($filteredUser) < 4) {

          $formErrors[] = '<p class="msg">Username must be larger than 4 characters</p>';

        }

      }

      if (isset($password) && isset($password2)) {

        if (empty($password)) {

          $formErrors[] = '<p class="msg">Sorry password can\'t be empty</p>';

        }

        $pass1 = sha1($password);
        $pass2 = sha1($password2);

        if ($pass1 !== $pass2) {

          $formErrors[] = '<p class="msg">Sorry password is not match</p>';

        }

      }

      if (isset($email)) {

        $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true) {

          $formErrors[] = '<p class="msg">This email is not valid</p>';

        }
      }

      // Check if there's no error proceed the user add

      if (empty($formErrors)) {

        // Check if user exist in database

        $check = checkItem("Username", "users", $username);

        if ($check == 1) {

          $formErrors[] = "<p class='msg'>Sorry this user is exists</p>";

        } else {

          // Insert userinfo in database

          $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date) VALUES(:zuser, :zpass, :zemail, 0, now())");

          $stmt->execute(array(

            'zuser' => $username,
            'zpass' => sha1($password),
            'zemail' => $email
          ));

          //Echo success message

          $successMsg = "Congrats you are now registerd user";

        }

      }

  }

}
?>

<div class="container login-page">
  <h1 class="text-center">
       <span class="selected" data-class="login">Login</span> |
       <span data-class="signup">Signup</span>
   </h1>

  <!-- Start login page -->
   <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

     <div class="input-container">
           <input
                  class       ="form-control"
                  type        ="text"
                  name        ="username"
                  autocomplete="off"
                  placeholder ="Type your username"
                  required
                  />
     </div>

     <div class="input-container">
           <input
                  class       ="form-control"
                  type        ="password"
                  name        ="password"
                  autocomplete="new-password"
                  placeholder ="Type your password"
                  required
                  />

     </div>

     <input
            class="btn btn-primary btn-block"
            name ="login"
            type ="submit"
            value="Login"
            />

   </form>
  <!-- End login page -->

  <!-- Start signup page -->
   <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

    <div class="input-container">
         <input
                pattern     =".{4,}"
                title       ="Username must be four character or more than"
                class       ="form-control"
                type        ="text"
                name        ="username"
                autocomplete="off"
                placeholder ="Type your username"
                required
                />
     </div>

   <div class="input-container">
        <input
               minlength   ="4"
               class       ="form-control"
               type        ="password"
               name        ="password"
               autocomplete="new-password"
               placeholder ="Type your password"
               required
               />
         </div>

   <div class="input-container">
        <input
                minlength   ="4"
                class       ="form-control"
                type        ="password"
                name        ="password2"
                autocomplete="new-password"
                placeholder ="Type a password again"
                required
                />
    </div>

    <div class="input-container">
    <input
           class      ="form-control"
           type       ="email"
           name       ="email"
           placeholder="Type a valid email"
           />
     </div>

    <input
           class ="btn btn-success btn-block"
           name  ="signup"
           type  ="submit"
           value ="Signup"
           />

   </form>
   <!-- End signup page -->

   <div class="the-errors text-center">
       <?php

          if (!empty($formErrors)) {

            foreach ($formErrors as $error) {

              echo $error . "<br />";
            }
          }

          if (isset($successMsg)) {

            echo "<div class='msg success'>". $successMsg ."</div>";
          }
       ?>
   </div>
</div>

<?php
  include $tpl . "footer.php";
  ob_end_flush();
?>
