<?php
ob_start();
session_start();
include 'init.php';
?>

   <div class="container">
       <div class="row">
       <?php
		  
		  if (isset($_GET['name'])) {
			  $tag = $_GET['name'];
			  echo "<div style='width:1140px;'><h1 class='text-center'>" . $tag . "</h1></div>";
			 
			  $tagItems = getAllFrom("*", "items", "where tags like '%$tag%'", "AND approve = 1", "ID_item", "ASC");
			  foreach ($tagItems as $item) {
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
			  
			  echo "You must enter tag name";
			  
		  }
       ?>
     </div>
   </div>

<?php
include  $tpl . 'footer.php';
ob_end_flush();
?>
