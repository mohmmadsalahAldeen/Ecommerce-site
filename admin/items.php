<?php
// Items page

ob_start(); // output buffering start

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])) {

  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  if ($do == 'Manage') {

      $stmt = $con->prepare("SELECT
                                  items.*,
                                  categories.Name AS category_name, users.Username
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
                             ORDER BY
                                  ID_item DESC");

      // execute the statement

      $stmt->execute();

      // Assign to variable

      $items = $stmt->fetchAll();

      if (! empty($items)) {

    ?>
      <h1 class="text-center">Manage items</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding date</td>
              <td>Category</td>
              <td>Username</td>
              <td>Control</td>
            </tr>
            <?php
              foreach ($items as $item) {
                echo "<tr>";
                   echo "<td>" . $item['ID_item'] . "</td>";
                   echo "<td>" . $item['Name'] . "</td>";
                   echo "<td>" . $item['Description'] . "</td>";
                   echo "<td>" . $item['Price'] . "</td>";
                   echo "<td>" . $item['Add_Date'] . "</td>";
                   echo "<td>" . $item['category_name']. "</td>";
                   echo "<td>" . $item['Username'] . "</td>";
                   echo "<td>
                      <a href='items.php?do=Edit&itemid=" . $item['ID_item'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                      <a href='items.php?do=Delete&itemid=" .$item['ID_item']. "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";

                      if ($item['approve'] == 0) {
                        echo "<a style='margin-left:5px;' href='items.php?do=approve&itemid=" . $item['ID_item'] ."' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
                      }
                      echo "</td>";
                echo "</tr>";
              }
            ?>
            <tr>
          </table>
        </div>
        <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New item</a>
      </div>

    <?php } else {

      echo "<div class='container'>";
         echo "<div class='nice-message'>There\'s no items to show</div>";
         echo "<a href='items.php?do=Add' class='btn btn-sm btn-primary'>
          <i class='fa fa-plus'></i> New item
          </a>";
      echo "</div>";
    } ?>

 <?php

  } elseif ($do == 'Add') { ?>

     <h1 class="text-center">Add new item</h1>
     <div class="container">
          <form class="form-horizontal" action="?do=Insert" method="POST">

            <!-- Start name field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10 col-md-6">
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      required="required"
                      placeholder="Name of the item" />
              </div>
            </div>
            <!-- End name field -->

            <!-- Start description field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10 col-md-6">
                <input
                  type="text"
                  name="description"
                  class="form-control"
                  required="required"
                  placeholder="Description of the item" />
              </div>
            </div>
            <!-- End description field-->

            <!-- Start price field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10 col-md-6">
                <input
                  type="text"
                  name="price"
                  class="form-control"
                  required="required"
                  placeholder="Price of the item" />
              </div>
            </div>
            <!-- End price field-->

            <!-- Start Country field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Country</label>
              <div class="col-sm-10 col-md-6">
                <input
                  type="text"
                  name="country"
                  class="form-control"
                  required="required"
                  placeholder="Country of made" />
              </div>
            </div>
            <!-- End country field-->

            <!-- Start status field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10 col-md-6">
                <select class="form-control" name="status" style="height:40px;">
                  <option value="0">...  </option>
                  <option value="1">New  </option>
                  <option value="2">Like New</option>
                  <option value="3">Used</option>
                  <option value="4">Very old</option>
                 </select>
              </div>
            </div>
            <!-- End status field -->

            <!-- Start members field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Member</label>
              <div class="col-sm-10 col-md-6">
                <select class="form-control" name="member" style="height:40px;">
                  <option value="0">...  </option>
                  <?php
				    $allMembers = getAllFrom("*", "users", "", "", "ID_user");
                    foreach ($allMembers as $user) {
                       echo "<option value='" . $user['ID_user']. "'>" . $user['Username'] . "</option>";
                    }

                  ?>
                 </select>
              </div>
            </div>
            <!-- End members field -->

            <!-- Start categories field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Category</label>
              <div class="col-sm-10 col-md-6">
                <select class="form-control" name="category" style="height:40px;">
                   <option value="0">...</option>
                   <?php
				     $allCats = getAllFrom("*" ,"categories" ,"where parent = 0" ,"" ,"ID_cat");
                     foreach ($allCats as $cat) {
                       echo "<option value='". $cat['ID_cat'] ."'>" . $cat['Name'] . "</option>";
					   $childCats = getAllFrom("*" ,"categories" ,"where parent = {$cat['ID_cat']}" ,"" ,"ID_cat");
					   foreach($childCats as $child) {
						   echo "<option value='".$child['ID_cat']."'>---".$child['Name'] ."</option>";
					   }
                     }
                   ?>
                </select>
              </div>
            </div>
            <!-- End categories field -->
			
            <!-- Start tags field -->
			<div class="form-group form-group-lg">
			   <label class="col-sm-2 control-label">Tags</label>
			   <div class="col-sm-10 col-md-6">
			        <input 
					    type="text" 
						name="tags" 
						class="form-control" 
						placeholder="Separate tags with comma (,)"/>
			   </div>
			</div>
			<!-- End tage field -->
			
            <!-- Start submit field -->
            <div class="form-group form-group-lg">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add item" class="btn btn-primary btn-lg" />
              </div>
            </div>
            <!-- End submit field -->
          </form>
     </div>

  <?php
  } elseif ($do == 'Insert' ) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      echo "<h1 class='text-center'>Insert item</h1>";
      echo "<div class='container'>";

      // Get variables from the form

      $Name     = $_POST['name'];
      $desc     = $_POST['description'];
      $price    = $_POST['price'];
      $country  = $_POST['country'];
      $status   = $_POST['status'];
      $member   = $_POST['member'];
      $category = $_POST['category'];
	  $tags     = $_POST['tags'];

       // Validate the form

       $formErrors = array();

       if (empty($Name)) {
         $formErrors[] = 'Name can\'t be <strong>Empty</strong>';
       }

       if (empty($desc)) {
         $formErrors[] = 'Description can\'t be <strong>Empty</strong>';
       }

       if (empty($price)) {
         $formErrors[] = 'Price can\'t be <strong>Empty</strong>';
       }

       if (empty($country)) {
         $formErrors[] = 'Country can\'t be <strong>Empty</strong>';
       }

       if ($status == 0) {
         $formErrors[] = 'You must choose the <strong>status</strong>';
       }

       if ($member == 0) {
         $formErrors[] = 'You must choose the <strong>member</strong>';
       }

       if ($category == 0) {
         $formErrors[] = 'You must choose the <strong>category</strong>';
       }
       // loop into errors array echo interface

       foreach ($formErrors as $error) {
         echo '<div class="alert alert-danger">' . $error . '</div>';
       }

       // check if there's no errors proceed the update operation

       if (empty($formErrors)) {

           // Insert userinfo in database

           $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, ID_cat, ID_user, tags) VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcategory, :zmember, :ztags)");

           $stmt->execute(array(

             'zname'     => $Name,
             'zdesc'     => $desc,
             'zprice'    => $price,
             'zcountry'  => $country,
             'zstatus'   => $status,
             'zcategory' => $category,
             'zmember'   => $member,
			 'ztags'     => $tags

           ));

           // echo success message

           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted</div>';

           redirectHome($theMsg, 'back');

         }

    } else {

      echo '<div class="container">';

      $theMsg = "<div class='alert alert-danger'>sorry you cant browse this page directly</div>";

      redirectHome($theMsg);

      echo "</div>";

    }

    echo "</div>";

  } elseif ($do == 'Edit') {

    //check if get request userid is numeric & get the integer value of It

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    // Select all data depend on this id

    $stmt = $con->prepare("SELECT * FROM items WHERE ID_item = '$itemid'");

    // Execute query

    $stmt->execute(array($itemid));

    // Fetch the data

    $item = $stmt->fetch();

    // The row count

    $count = $stmt->rowCount();

    // If there's such id show the form

    if ($count > 0 ) { ?>

       <h1 class="text-center">Edit item</h1>
       <div class="container">
         <form class="form-horizontal" action="?do=Update" method="POST">
           <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
           <!-- Start name field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Name</label>
             <div class="col-sm-10 col-md-6">
               <input
                   type="text"
                   name="name"
                   class="form-control"
                   required="required"
                   placeholder="Name of the item"
                   value="<?php echo $item['Name'] ?>"
                   />
             </div>
           </div>
           <!-- End name field -->

           <!-- Start description field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Description</label>
             <div class="col-sm-10 col-md-6">
               <input
                   type="text"
                   name="description"
                   class="form-control"
                   required="required"
                   placeholder="Description of the item"
                   value="<?php echo $item['Description'] ?>"
                   />
             </div>
           </div>
           <!-- End description field -->

           <!-- Start price field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Price</label>
             <div class="col-sm-10 col-md-6">
               <input
                   type="text"
                   name="price"
                   class="form-control"
                   required="required"
                   placeholder="Price of the item"
                   value="<?php echo $item['Price'] ?>"
                   />
             </div>
           </div>
           <!-- End price field -->

           <!-- Start country field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Country</label>
             <div class="col-sm-10 col-md-6">
               <input
                   type="text"
                   name="country"
                   class="form-control"
                   required="required"
                   placeholder="Country of the item"
                   value="<?php echo $item['Country_Made'] ?>"
                   />
             </div>
           </div>
           <!-- End country field -->

           <!-- Start status field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Status</label>
             <div class="col-sm-10 col-md-6">
               <select class="form-control" name="status" style="height:40px;">
                 <option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?> >New  </option>
                 <option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
                 <option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?> >Used</option>
                 <option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?> >Very old</option>
                </select>
             </div>
           </div>
           <!-- End status field -->

           <!-- Start members field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Member</label>
             <div class="col-sm-10 col-md-6">
               <select class="form-control" name="member" style="height:40px;">
                 <?php
                    $stmt = $con->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                      echo "<option value='" . $user['ID_user'] . "'";
                      if ($item['ID_user'] == $user['ID_user']) { echo 'selected'; }
                      echo ">" . $user['Username'] . "</option>";
                    }
                 ?>
               </select>
             </div>
           </div>
           <!-- End members field -->

           <!-- Start category field -->
           <div class="form-group form-group-lg">
             <label class="col-sm-2 control-label">Category</label>
             <div class="col-sm-10 col-md-6">
               <select class="form-control" name="category" style="height:40px;">
                 <?php
                    $stmt2 = $con->prepare("SELECT * FROM categories");
                    $stmt2->execute();
                    $cats = $stmt2->fetchAll();
                    foreach ($cats as $cat) {
                      echo "<option value='" . $cat['ID_cat'] . "'";
                      if ($item['ID_cat'] == $cat['ID_cat']) { echo 'selected'; }
                      echo ">" . $cat['Name'] . "</option>";
                    }
                 ?>
               </select>
             </div>
           </div>
           <!-- End category field -->
		   
           <!-- Start tags field -->
		   <div class="form-group form-group-lg">
		       <label class="col-sm-2 control-label">Tags</label>
			   <div class="col-sm-10 col-md-6">
			       <input 
				       type="text"
					   name="tags"
					   class="form-control"
					   placeholder="Separate tags with comma(,)"
					   value="<?php echo $item['tags']?>" />
			   </div>
		   </div>
		   <!-- End tags field -->
		   
           <!-- Start submit field -->
           <div class="form-group form-group-lg">
             <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="Save item" class="btn btn-primary btn-sm" />
             </div>
           </div>
           <!-- End submit field -->
		   
         </form>

         <?php
           // Select all comments except admin

           $stmt = $con->prepare("SELECT
                                       comments.*, users.Username AS Uname
                                  FROM
                                       comments
                                  INNER JOIN
                                       users
                                  ON
                                       users.ID_user = comments.ID_user
                                  WHERE
                                       ID_item = ?");

          // Execute the statement

          $stmt->execute(array($itemid));

          // Assign to variable

          $rows = $stmt->fetchAll();

          if (!empty($rows)) {

         ?>

         <h1 class="text-center">Manage [ <?php echo $item['Name'] ?>] comments</h1>
         <div class="table-responsive">
             <table class="main-table text-center table table-bordered">
                <tr>
                  <td>Comment</td>
                  <td>User name</td>
                  <td>Added date</td>
                  <td>Control</td>
                </tr>
                <?php
                  foreach ($rows as $row) {
                    echo "<tr>";
                       echo "<td>" . $row['comment']. "</td>";
                       echo "<td>" . $row['Uname']. "</td>";
                       echo "<td>" . $row['comment_date']. "</td>";
                       echo "<td>
                            <a href='comments.php?do=Edit&comid=".$row['ID_comment']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                            <a href='comments.php?do=Delete&comid=".$row['ID_comment']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

                            if ($row['status'] == 0) {

                              echo "<a href='comments.php?do=Approve&comid=" . $row['ID_comment']. "' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";

                            }
                            echo "</td>";
                   echo "</tr>";
                  }
                ?>
                <tr>
             </table>
         </div>
       <?php } ?>
       </div>

   <?php

   // If there's no such id show error message

    } else {

        echo "<div class='container'>";

        $theMsg = '<div class="alert alert-danger">Theres no such id</div>';

        redirectHome($theMsg);

        echo "</div>";
    }

  } elseif ($do == 'Update') {

    echo "<h1 class='text-center'>Update item</h1>";
    echo "<div class='container'>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // Get variables from the form

      $Id          = $_POST['itemid'];
      $Name        = $_POST['name'];
      $Description = $_POST['description'];
      $Price       = $_POST['price'];
      $Country     = $_POST['country'];
      $Status      = $_POST['status'];
      $Member      = $_POST['member'];
      $Category    = $_POST['category'];
	  $Tags        = $_POST['tags'];

      // Validate the form

      $formErrors = array();

      if (empty($Name)) {
        $formErrors[] = 'Name cant be <strong>empty</strong>';
      }

      if (empty($Description)) {
        $formErrors[] = 'Description cant be <strong>empty</strong>';
      }

      if (empty($Price)) {
        $formErrors[] = 'Price cant be <strong>empty</strong>';
      }

      if (empty($Country)) {
        $formErrors[] = 'Country cant be <strong>empty</strong>';
      }

      if ($Status == 0) {
        $formErrors[] = 'You must choose the <strong>status</strong>';
      }

      if ($Member == 0) {
        $formErrors[] = 'You must choose the <strong>member</strong>';
      }

      if ($Category == 0) {
        $formErrors[] = 'you must choose the <strong>category</strong>';
      }

      // Lopp into errors array and echo it

      foreach ($formErrors as $error) {
        echo "<div class='alert alert-danger'>" . $error . "</div>";
      }

      // check if there's no error procees the update operation

      if (empty($formErrors)) {

        // Update the database with this info

        $stmt = $con->prepare("UPDATE
                                    items
                               SET
                                    Name         = '$Name',
                                    Description  = '$Description',
                                    Price        = '$Price',
                                    Country_Made = '$Country',
                                    Status       = '$Status',
                                    ID_cat       = '$Category',
                                    ID_user      = '$Member',
									tags         = '$Tags'
                               WHERE
                                    ID_item      = '$Id'
                                  ");

       $stmt->execute(array($Name, $Description, $Price, $Country, $Status, $Member, $Category, $Tags, $Id));

       // Echo success message

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record updated </div>";

       redirectHome($theMsg, 'back');

      }

    } else {

     $theMsg = "<div class='alert alert-danger'>Sorry you can't browse this page directly</div>";

     redirectHome($theMsg);
    }

    echo "</div>";

  } elseif ($do == 'Delete') {

    echo "<h1 class='text-center'>Delete item</h1>";
    echo "<div class='container'>";

        // Check if get request item_id is numeric & get the integer value of it

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        // Select all data depend on this id

        $check = checkItem('ID_item', 'items', $itemid);

        // If there's such id show the form

        if ($check > 0) {

          $stmt = $con->prepare("DELETE FROM items WHERE ID_item = :zitemId");

          $stmt->bindParam(":zitemId", $itemid);

          $stmt->execute();

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record deleted</div>";

          redirectHome($theMsg);

        } else {
          $theMsg = "<div class='alert alert-danger'>This is id not exist</div>";

          redirectHome($theMsg);

        }

    echo "</div>";

  } elseif ($do == 'approve') {

     echo "<h1 class='text-center'>Approve item</h1>";
     echo "<div class='container'>";

        // check if get request item id is numeric & get the integer value of it

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;

        // Select all data depend on this id

        $check = checkItem('ID_item', 'items', $itemid);

        // if  there's such id show the form

        if ($check > 0) {

          $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE ID_item = '$itemid'");

          $stmt->execute(array($itemid));

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record updated</div>";

          redirectHome($theMsg, 'back');

        } else {
          $theMsg = "<div class='alert alert-danger'>This id is not exist</div>";

          redirectHome($theMsg);

        }

      echo "</div>";
  }

  include $tpl . 'footer.php';

} else {

  header('Location: index.php');

  exit();
}

ob_end_flush(); // Release the output

?>
