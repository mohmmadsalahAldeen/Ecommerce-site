<?php
    ob_start();
    session_start();
    $pageTitle = "Show items";
    include "init.php";

    //Check if get request item is muneric & get its integer value
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    //Select all data depend on this id
    $stmt = $con->prepare("SELECT
                                items.*,
                                categories.Name AS category_name,
                                users.Username
                           FROM
                                items
                           INNER JOIN
                                categories
                           ON
                                categories.ID_cat = items.ID_cat
                           INNER JOIN
                                users
                           ON
                               users.ID_user = items.ID_user
                           WHERE
                                ID_item = '$itemid'
                           AND
                                approve = 1");

    //Execute auery
    $stmt->execute(array($itemid));

    $count = $stmt->rowCount();

    if ($count > 0) {

    //Fetch the data
    $item = $stmt->fetch();
?>

<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
    </div>
    <div class="col-md-9 item-info">
      <h2><?php echo $item['Name']         ?></h2>
      <p><?php echo $item['Description']  ?></p>
      <ul class="list-unstyled">
          <li>
            <i class="fa fa-calendar fa-fw"></i>
            <span>Added date</span> :<?php echo $item['Add_Date']     ?>
          </li>
          <li>
            <i class="fa fa-money fa-fw"></i>
            <span>Price </span>     :$<?php echo $item['Price']        ?>
          </li>
          <li>
            <i class="fa fa-building fa-fw"></i>
            <span>Made in </span>   :<?php echo $item['Country_Made'] ?>
          </li>
          <li>
            <i class="fa fa-tags fa-fw"></i>
            <span>Category</span> : <a href="categories.php?pageid= <?php echo $item['ID_cat']  ?>"> <?php echo $item['category_name']?></a>
          </li>
          <li>
            <i class="fa fa-user fa-fw"></i>
            <span>Added by</span> : <a href="#"> <?php echo $item['Username']?></a>
          </li>
		  <li class='tags-items'>
		    <i class="fa fa-user fa-fw"></i>
			<span>Tags</span> :
			<?php 
			    $allTags = explode(",", $item['tags']);
				foreach($allTags as $tag) {
					$tag = str_replace(' ', '', $tag);
					$lowertag = strtolower($tag);
					if (! empty($tag)) {
					echo "<a href='tags.php?name={$lowertag}'>".$tag. '</a>';
					}
				}
			?>
		  </li>
      </ul>
    </div>
  </div>
  <hr class="custom-hr">
  <?php if (isset($_SESSION['user'])) { ?>
  <!-- Start add comment -->
  <div class="row">
    <div class="col-md-offset-3">
      <div class="add-comment">
          <h3>Add your comment</h3>
          <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['ID_item'] ?>" method="POST">
            <textarea name="comment" required></textarea>
            <input class="btn btn-primary" type="submit" vlaue="Add comment">
          </form>
          <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

               $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
               $itemid  = $item['ID_item'];
               $userid  = $_SESSION['IDu'];

               if (!empty($comment)) {

                 $stmt = $con->prepare("INSERT INTO
                   comments(comment, status, comment_date, ID_item, ID_user)
                   VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");

                 $stmt->execute(array(

                   'zcomment' => $comment,
                   'zitemid'  => $itemid,
                   'zuserid'  => $userid

                 ));

                 if ($stmt) {
                   echo "<div class='alert alert-success'>Comment added</div>";
                 }
               }
            }

          ?>
      </div>
    </div>
  </div>
  <!-- End add comment -->
  <?php } else {

     echo "<a href='login.php'>Login</a> or <a href='login.php'>Register</a> to add comment";

  } ?>
  <hr class="custom-hr">
  <?php

  $varId_item = $item['ID_item'];

  // Select all users except admin
  $stmt = $con->prepare("SELECT
                              comments.*, users.Username
                         FROM
                              comments
                         INNER JOIN
                              users
                         ON
                              users.ID_user = comments.ID_user
                         WHERE
                              ID_item = ?
                         AND
                              status = 1
                         ORDER BY
                              ID_comment DESC ");
  // Execute the statement

  $stmt->execute(array($item['ID_item']));

  // Assign to variable

  $comments = $stmt->fetchAll();

  ?>

<?php foreach ($comments as $comment) { ?>
         <div class="comment-box">
               <div class='row'>
                  <div class='col-sm-2 text-center'>
                    <img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
                    <?php echo $comment['Username'] ?>
                  </div>
                  <div class='col-md-10'>
                    <p class="lead"><?php echo $comment['comment'] ?></p>
                  </div>
              </div>
         </div>
         <hr class="custom-hr">
    <?php  } ?>
</div>
<?php
} else {
  echo "<div class='container'>";
      echo "<div class='alert alert-danger'>There\'s no such id or this this is waiting approve</div>";
  echo "</div>";
}
    include $tpl . 'footer.php';
    ob_end_flush();
?>
