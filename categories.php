<?php
ob_start();
session_start();
include 'init.php';
?>

   <div class="container">
       <h1 class="text-center">Show category items</h1>
       <div class="row">
       <?php
		  
		  if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
			  
			  $category = intval($_GET['pageid']);
			  
			  $allItems = getAllFrom("*", "items", "where ID_cat = {$category}", "AND approve = 1", "ID_item", "ASC");
			  
			  foreach ($allItems as $item) {
			   echo "<div class='col-sm-6 col-md-3'>";
				  echo "<div class='thumbnail item-box'>";
					  echo "<span class='price-tag'>" . $item['Price'] . "</span>";
					  echo "<img class='img-responsive' src='img.png' alt=''/>";
						 echo "<div class='caption'>";
							echo "<h3><a href='items.php?itemid=" . $item['ID_item'] . "'>" . $item['Name']. "</a></h3>";
							echo "<p>"  . $item['Description']. "</p>";
							echo "<div class='date'>" . $item['Add_Date'] . "</div>";
						 echo "</div>";
				   echo "</div>";
			   echo "</div>";
			  }
			  
		  } else {
			  echo "You must enter page id";
		  }
       ?>
     </div>
   </div>

<?php
include  $tpl . 'footer.php';
ob_end_flush();
?>
