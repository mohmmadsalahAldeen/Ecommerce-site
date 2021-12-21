<?php
    ob_start();
    session_start();
    $pageTitle = 'Create new item';
    include 'init.php';
    if (isset($_SESSION['user'])) {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $formErros = array();

            $name     = filter_var($_POST['name'],       FILTER_SANITIZE_STRING);
            $desc     = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price    = filter_var($_POST['price'],      FILTER_SANITIZE_NUMBER_INT);
            $country  = filter_var($_POST['country'],    FILTER_SANITIZE_STRING);
            $status   = filter_var($_POST['status'],     FILTER_SANITIZE_NUMBER_INT);
            $category = filter_var($_POST['category'],   FILTER_SANITIZE_NUMBER_INT);
			$tags     = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

            if (strlen($name) < 4) {

              $formErrors[] = "Item name must be at least 4 characters";

            }

            if (strlen($desc) < 10) {

              $formErrors[] = "Item description must be at least 10 characters";

            }

            if (empty($price)) {

              $formErrors[] = "Item price must be not empty ";

            }

            if (strlen($country) < 2) {

              $formErrors[] = "Item country must at least 2 characters";

            }

            if (empty($status)) {

              $formErrors[] = "Item status must be not empty";
            }

            if (empty($category)) {

              $formErrors[] = "Item category must be not empty";

            }

            // Check if there's no error procced the update opertaion

            if (empty($formErrors)) {

              // Insert userinfo in database

              $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, ID_cat, ID_user, tags) VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");

              $stmt->execute(array(

                'zname'   => $name,
                'zdesc'   => $desc,
                'zprice'  => $price,
                'zcountry'=> $country,
                'zstatus' => $status,
                'zcat'    => $category,
                'zmember' => $_SESSION['IDu'],
				'ztags'   => $tags

              ));

                // Echo success message
                if ($stmt) {

                $successMsg = "Item has been added";

              }

            }

       }
?>

<h1 class="text-center"><?php echo $pageTitle ?></h1>
<div class="create-ad block">
  <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $pageTitle ?></div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8">
            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
              <!-- Start name field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-10 col-md-9">
                  <input
                      pattern =".{4,}"
                      title = "This is field require at least 4 characters"
                      type="text"
                      name="name"
                      class="form-control live"
                      placeholder="Name of the item"
                      data-class=".live-title"
                      required
                      />
                </div>
              </div>
              <!-- End name field -->

              <!-- Start description field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Description</label>
                <div class="col-sm-10 col-md-9">
                  <input
                     pattern=".{10,}"
                     title="This is field require at least 10 characters"
                     type="text"
                     name="description"
                     class="form-control live"
                     placeholder="Description of the item"
                     data-class=".live-desc"
                     required
                  />
                </div>
              </div>
              <!-- End description field  -->
              <!-- Start price field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Price</label>
                <div class="col-sm-10 col-md-9">
                  <input
                      type="text"
                      name="price"
                      class="form-control live"
                      placeholder="Price of the item"
                      data-class=".live-price"
                      required
                  />
                </div>
              </div>
              <!-- End price field -->
              <!-- Start country field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Country</label>
                <div class="col-sm-10 col-md-9">
                  <input
                      type="text"
                      name="country"
                      class="form-control"
                      placeholder="Country of made"
                      required
                  />
                </div>
              </div>
              <!-- End country field -->
              <!-- Start status field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Status</label>
                <div class="col-sm-10 col-md-9">
                  <select class="form-control" name="status" style="height:40px;" required>
                    <option value="">...</option>
                    <option value="1">New</option>
                    <option value="2">Like new</option>
                    <option value="3">Used</option>
                    <option value="4">Very old</option>
                  </select>
                </div>
              </div>
              <!-- End status field -->
              <!-- Start categories field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Category</label>
                <div class="col-sm-10 col-md-9">
                  <select class="form-control" name="category" style="height:40px;" required>
                        <option value="">...</option>
                        <?php
                            $cats = getAllFrom('*', 'categories', '', '', 'ID_cat');
                            foreach ($cats as $cat) {
                              echo "<option value='" . $cat['ID_cat'] . "'>" . $cat['Name'] . "</option>";
                            }
                     ?>
                  </select>
                </div>
              </div>
              <!-- End categories field -->
			  <!-- Start tags field -->
				<div class="form-group form-group-lg">
				   <label class="col-sm-3 control-label">Tags</label>
				   <div class="col-sm-10 col-md-9">
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
                <div class="col-sm-offset-3 sol-sm-9">
                  <input type="submit" value="Add item" class="btn btn-primary btn-lg" />
                </div>
              </div>
              <!-- End submit field -->
            </form>
          </div>
          <div class="col-md-4">
            <div class="thumbnail item-box live-preview">
              <span class="price-tag">
                $<span class="live-price">0</span>
              </span>
              <img class="img-responsive" src="img.png" alt="" />
              <div class="caption">
                <h3 class="live-title">Title</h3>
                <p class="live-desc">Description</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Start looping through errors -->
        <?php
            if (!empty($formErrors)) {
              foreach ($formErrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
              }
            }
            if (isset($successMsg)) {

              echo "<div class='alert alert-success'>". $successMsg ."</div>";

            }
        ?>
        <!-- End lopping through errors  -->
      </div>
    </div>
  </div>
</div>
<?php
    } else {
        header('Location: login.php');
        exit();
    }
      include $tpl . 'footer.php';
      ob_end_flush();
?>
