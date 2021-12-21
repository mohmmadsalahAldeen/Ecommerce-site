<?php

/*
CATEGORIES page
*/

ob_start(); // output buffering start

session_start();

$pageTitle = 'Categories';

if (isset($_SESSION['Username'])) {

  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

  if ($do == 'Manage') {

    $sort = 'ASC';

    $sort_array = array('ASC','DESC');

    if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

      $sort = $_GET['sort'];

    }

    $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

   // Execute the statement

    $stmt2->execute();

   // Assign to variable

    $cats = $stmt2->fetchAll();

    if (!empty($cats)) {
    ?>

    <h1 class="text-center">Manage Categories</h1>
    <div class="container categories">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-edit"></i> Manage Categories
          <div class="option pull-right">
            <i class="fa fa-sort"></i> Ordering: [
            <a class ="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">ASC</a> |
            <a class ="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
            <i class="fa fa-eye"></i> View: [
            <span class="active" data-view="full">Full</span> |
            <span data-view="classic">Classic</span> ]
          </div>
        </div>
        <div class="panel-body">
          <?php
             foreach ($cats as $cat) {
               echo "<div class='cat'>";
                     echo "<div class='hidden-buttons'>";
                          echo "<a href='categories.php?do=Edit&catid=".$cat['ID_cat']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                          echo "<a href='categories.php?do=Delete&catid=" . $cat['ID_cat'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                     echo "</div>";
                     echo "<h3>" . $cat['Name'] . "</h3>";
                     echo "<div class='full-view'>";
                           echo "<p>"; if($cat['Description'] == '') { echo 'This category has no description'; } else { echo $cat['Description'];} echo  "</p>";
                           if($cat['Visibility'] == 1)    { echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';          }
                           if($cat['Allow_Comment'] == 1) { echo '<span class="commenting"><i class="fa fa-close"></i>Comment disabled</span>';}
                           if($cat['Allow_Ads'] == 1)     { echo '<span class="adverties"><i class="fa fa-close"></i>Ads disabled</span>';     }

                           // Get child categories
                           $childCats = getAllFrom("*", "categories", "where parent = {$cat['ID_cat']}", "", "ID_cat", "ASC");
                           if (!empty($childCats)) {
                                 echo "<h4 class='child-head'>Child categories</h4>";
                                 echo "<ul class='list-unstyled child-cats'>";
                                 foreach ($childCats as $c) {
                                   echo "<li class='child-link'>
                                   <a href='categories.php?do=Edit&catid=".$c['ID_cat']."'>" . $c['Name'] . "</a>
                                   <a href='categories.php?do=Delete&catid=".$c['ID_cat']."' class='show-delete confirm'>Delete</a>
                                   </li>";
                                 }
                                 echo "</ul>";
                               }
                               echo "</div>";

               echo "</div>";
               echo "<hr>";
           }
          ?>
        </div>
      </div>
      <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add new category</a>
    </div>

  <?php } else {

     echo "<div class='container'>";
         echo "<div class='nice-message'>There\'s no category to show </div>";
         echo "<a class='add-category btn btn-primary' href='categories.php?do=Add'><i class='fa fa-plus'></i>Add new category</a>";
     echo "</div>";

  } ?>

    <?php

  } elseif ($do == 'Add') { ?>

    <h1 class="text-center">Add new Category</h1>
    <div class="container">
      <form class="form-horizontal" action="?do=Insert" method="POST">
        <!-- Start Name field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name of the Category" required="required"/>
          </div>
        </div>
        <!-- End name field -->
        <!-- Start description field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="description" class="form-control" placeholder="Describe the Category" />
          </div>
        </div>
        <!-- End description field -->
        <!-- Start ordering field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Ordering</label>
          <div class="col-sm-10 col-md-4">
               <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories"/>
          </div>
        </div>
        <!-- End ordering field -->
        <!-- Start category type -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Parent?</label>
          <div class="col-sm-10 col-md-4">
            <select class="form-control" name="parent" style="height:40px;">
                <option value="0">None</option>
                <?php
                  $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID_cat", "ASC");
                  foreach ($allCats as $cat) {
                    echo "<option value='" .$cat['ID_cat']. "'>".$cat['Name']."</option>";
                  }
                ?>
           </select>
          </div>
        </div>
        <!-- End category type -->
        <!-- Start visibility field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Visible</label>
          <div class="col-sm-10 col-md-4">
            <div>
               <input id="vis-yes" type="radio" name="visibility" value="0" checked />
               <label for="vis-yes">Yes</label>
            </div>
            <div>
              <input id="vis-no" type="radio" name="visibility" value="1" />
              <label for="vis-no">No</label>
            </div>
          </div>
        </div>
        <!-- End visibility field -->
        <!-- Start commenting field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Allow commenting</label>
          <div class="col-sm-10 col-md-4">
            <div>
               <input id="com-yes" type="radio" name="commenting" value="0" checked />
               <label for="com-yes">Yes</label>
            </div>
            <div>
              <input id="com-no" type="radio" name="commenting" value="1" />
              <label for="com-no">No</label>
            </div>
          </div>
        </div>
        <!-- End commenting field -->
        <!-- Start ads field -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Allow Ads</label>
          <div class="col-sm-10 col-md-4">
            <div>
               <input id="ads-yes" type="radio" name="ads" value="0" checked />
               <label for="ads-yes">Yes</label>
            </div>
            <div>
              <input id="ads-no" type="radio" name="ads" value="1" />
              <label for="ads-no">No</label>
            </div>
          </div>
        </div>
        <!-- End ads field -->
        <!-- Start Submit field -->
        <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
          </div>
        </div>
        <!-- End Submit field -->
      </form>
    </div>

    <?php
  } elseif ($do == 'Insert') {

    // insert member page

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      echo "<h1 class='text-center'>Insert Category</h1>";
      echo "<div class='container'>";

      // Get variables from the form

      $name     = $_POST['name'];
      $desc     = $_POST['description'];
      $parent   = $_POST['parent'];
      $order    = $_POST['ordering'];
      $visible  = $_POST['visibility'];
      $comment  = $_POST['commenting'];
      $ads      = $_POST['ads'];

     // check if Category exist in database

     $check = checkItem("Name", "categories", $name);

     if ($check == 1) {

       $theMsg = '<div class="alert alert-danger">sorry this Category is exist</div>';

       redirectHome($theMsg,'back');

     } else {

       // Insert Category in database

       $stmt = $con->prepare("INSERT INTO categories(Name, Description, parent, Ordering, Visibility , Allow_Comment, Allow_Ads) VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads) ");

       $stmt->execute(array(

         'zname'    => $name,
         'zdesc'    => $desc,
         'zparent'  => $parent,
         'zorder'   => $order,
         'zvisible' => $visible,
         'zcomment' => $comment,
         'zads'     => $ads
       ));

       // echo success message

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted</div>';

       redirectHome($theMsg, 'back');

     }

    } else {

      echo '<div class="container">';

      $theMsg = "<div class='alert alert-danger'>sorry you cant browse this page directly</div>";

      redirectHome($theMsg, 'back', 5);

      echo "</div>";

    }

    echo "</div>";

  } elseif ($do == 'Edit') {

    //check if get request userid is numeric & get the integer value of It

    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    // Select all data depend on this ID

    $stmt = $con->prepare("SELECT * FROM categories WHERE ID_cat = '$catid' ");

    // Execute query

    $stmt->execute(array($catid));

    // fetch the data

    $cat = $stmt->fetch();

    // The row count

    $count = $stmt->rowCount();

    // if there's such id the form

    if ($count > 0) { ?>

      <h1 class="text-center">Edit Category</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="catid" value="<?php echo $catid ?>" />
          <!-- Start Name field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
                 <input type="text" name="name" class="form-control" placeholder="Name of the Category" required="required" value = "<?php echo $cat['Name'] ?>" />
            </div>
          </div>
          <!-- End name field -->
          <!-- Start description field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
                 <input type="text" name="description" class="form-control" placeholder="Describe the Category" value="<?php echo $cat['Description'] ?>" />
            </div>
          </div>
          <!-- End description field -->
          <!-- Start ordering field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
                 <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories" value="<?php echo $cat['Ordering'] ?>" />
            </div>
          </div>
          <!-- End ordering field -->
		  
		  <!-- Start category type -->
			<div class="form-group form-group-lg">
			  <label class="col-sm-2 control-label">Parent?</label>
			  <div class="col-sm-10 col-md-4">
				<select class="form-control" name="parent" style="height:40px;">
					<option value="0">None</option>
					<?php
					  $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID_cat", "ASC");
					  foreach ($allCats as $c) {
						echo "<option value='" .$c['ID_cat']. "'";
						if ($cat['parent'] == $c['ID_cat']){echo 'Selected';}
						echo ">".$c['Name']."</option>";
					  }
					?>
			   </select>
			  </div>
			</div>
        <!-- End category type -->
		
          <!-- Start visibility field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-4">
              <div>
                 <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) { echo 'checked'; } ?>  />
                 <label for="vis-yes">Yes</label>
              </div>
              <div>
                <input id="vis-no" type="radio" name="visibility" value="1"   <?php if ($cat['Visibility'] == 1) { echo 'checked'; }  ?> />
                <label for="vis-no">No</label>
              </div>
            </div>
          </div>
          <!-- End visibility field -->
          <!-- Start commenting field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow commenting</label>
            <div class="col-sm-10 col-md-4">
              <div>
                 <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo 'checked'; } ?>  />
                 <label for="com-yes">Yes</label>
              </div>
              <div>
                <input id="com-no" type="radio" name="commenting" value="1"   <?php if ($cat['Allow_Comment'] == 1) { echo 'checked'; } ?> />
                <label for="com-no">No</label>
              </div>
            </div>
          </div>
          <!-- End commenting field -->
          <!-- Start ads field -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-4">
              <div>
                 <input id="ads-yes" type="radio" name="ads" value="0"  <?php if ($cat['Allow_Ads'] == 0) { echo 'checked'; } ?>/>
                 <label for="ads-yes">Yes</label>
              </div>
              <div>
                <input id="ads-no" type="radio" name="ads" value="1"  <?php if ($cat['Allow_Ads'] == 1) { echo 'checked'; } ?>/>
                <label for="ads-no">No</label>
              </div>
            </div>
          </div>
          <!-- End ads field -->
          <!-- Start Submit field -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                 <input type="submit" value="save Category" class="btn btn-primary btn-lg" />
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


  } elseif ($do == 'Update') {

     echo "<h1 class='text-center'>Update Category</h1>";
     echo "<div class='container'>";

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

       // get variable from the form

       $id           = $_POST['catid'];
       $name         = $_POST['name'];
       $desc         = $_POST['description'];
       $order        = $_POST['ordering'];
	   $parent       = $_POST['parent'];
       $visible      = $_POST['visibility'];
       $allowComment = $_POST['commenting'];
       $allowAds     = $_POST['ads'];

       // Update the database with this info

       $stmt = $con->prepare("UPDATE 
	                             categories 
							  SET 
							     Name          = '$name',
								 Description   = '$desc', 
								 Ordering      = '$order', 
								 parent        = '$parent', 
								 Visibility    = '$visible', Allow_Comment = '$allowComment', Allow_Ads     = '$allowAds' 
							  WHERE 
							     ID_cat = '$id' ");

       $stmt->execute(array($id ,$name ,$desc ,$order ,$parent ,$visible ,$allowComment ,$allowAds));

       // echo success message

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record updated</div>';

       redirectHome($theMsg, 'back');

     } else {

       $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';

       redirectHome($theMsg);
     }

  } elseif ($do == 'Delete') {

     echo "<h1 class='text-center'>Delete category</h1>";
     echo "<div class='container'>";
          // check if get request catid is numeric & get the integer value of it

          $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

          // Select all data depend on this id

          $check = checkItem('ID_cat', 'categories', $catid);

          // if theres such id show the form

          if ($check > 0) {

            $stmt = $con->prepare("DELETE FROM categories WHERE ID_cat = :zuser");

            $stmt->bindParam(":zuser", $catid);

            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record deleted</div>";

            redirectHome($theMsg, 'back') ;

          } else {

            $theMsg = '<div class="alert alert-danger">This id is not exist</div>';

            redirectHome($theMsg);

          }
     echo "</div>";
  }

  include $tpl . 'footer.php';

} else {

  header('Location : index.php');

  exit();

}

ob_end_flush(); // Release the output

?>
