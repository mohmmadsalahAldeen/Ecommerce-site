<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8" />
     <title><?php getTitle() ?></title>
     <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
     <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
     <link rel="stylesheet" href="<?php echo $css; ?>backend.css" />
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
	 
	 <style>
	 /* Start main rulez */

	  body {
		background-color: #F4F4F4;
		font-size: 16px;
		height: 3000px;
	  }

	  h1 {
		font-size: 55px;
		margin: 40px 0;
		font-weight: bold;
		color: #C0C0C0;
	  }

	  .input-container {
		position: relative;
	  }

	  .asterisk {
		font-size: 25px;
		position: absolute;
		right: 10px;
		top: 5px;
		color: #D20707;
	  }

	  .main-form .asterisk {
		font-size: 30px;
		position: absolute;
		right: 30px;
		top:8px;
		color: #D20707;
	  }

	  .nice-message {
		padding: 10px;
		background-color: #FFF;
		margin: 10px 0;
		border-left: 5px solid #080;
	  }

	  /* End main rulez */

	  /* Start bootstrap edits */
	  .navbar {
		border-radius: 0;
		margin-bottom: 0;
	  }

	  .navbar-nav > li > a,
	  .navbar-brand {
		padding:20px 12px;
	  }

	  .navbar-brand {
		font-size: 1em;
	  }

	  .navbar-dark .navbar-nav .active > .nav-link,
	  .navbar-dark .navbar-nav .nav-link.active,
	  .navbar-dark .navbar-nav .nav-link.show,
	  .navbar-dark .navbar-nav .show > .nav-link {

		  background-color: #3498db;
	  }

	  .dropdown-menu {
		background-color: #3498db;
		min-width: 180px;
		padding:0;
		font-size: 1em;
		border:none;
		border-radius: 0;
	  }

	  .dropdown-menu > li > a {
		color: #FFF;
		padding:10px 15px;
	  }

	  .dropdown-menu > li > a:focus,
	  .dropdown-menu > li > a:hover {
		color:#FFF;
		background-color: #8e44ad;
	  }

	  .form-control {
		position: relative;
	  }
	  /* End bootstrap edits */

	  /* Start header  */

	  .upper-bar {
		padding: 10px;
		background-color: #FFF;
	  }

	  .my-image {
		width: 32px;
		height:32px;
	  }

	  /* End header */

	  /* Start login page */

	  .login-page form,
	  .the-errors {
		max-width: 300px;
		margin: auto;
	  }

	  .login-page form input {
		margin-bottom: 10px;
	  }

	  .login-page [data-class="login"].selected {
		color: #337AB7;
	  }

	  .login-page [data-class="signup"].selected {
		color: #5cb85c;
	  }

	   .login-page h1 {
		color: #C0C0C0;
	  }

	  .login-page h1 span {
		cursor: pointer;
	  }

	  .login-page .signup {
		display: none;
	  }

	  .the-errors .msg {
		padding: 10px;
		text-align: left;
		border-left: 5px solid #cd6858;
		background-color: #fff;
		margin-bottom: 8px;
		border-right: 1px solid #e0e0e0;
		border-top: 1px solid #e0e0e0;
		border-bottom: 1px solid #e0e0e0;
		color: #919191;
	  }

	  .the-errors .error {
		border-left: 5px solid #cd6858;
	  }

	  /* End login page */

	  /* Start categories page */

	  .item-box {
		position: relative;
	  }

	  .item-box .price-tag {
		background-color: #B4B4B4;
		padding: 2px 10px;
		position: absolute;
		left: 0;
		top: 10px;
		font-weight: bold;
		color:#FFF;
	  }

	  .item-box .approve-status {
		position: absolute;
		top: 40px;
		left:0;
		background-color: #b85a5a;
		color: #FFF;
		padding: 3px 5px;
	  }

	  .item-box .caption p {
		height: 44px;
		max-height: 44px;
	  }
	  /* End categories page */

	  /* Start profile page */

	   .information {
		 margin-top: 20px;
	   }

	   .information ul {
		 padding:0;
		 margin:0;
	   }

	   .information ul li {
		 padding:10px;
	   }

	   .information ul li:nth-child(odd) {
		 background-color: #EEE;
	   }

	   .information ul li span {
		 display: inline-block;
		 width:120px;
	   }

	   .thumbnail .date {
		 text-align: right;
		 font-size: 13px;
		 color:#AAA;
		 font-weight: bold;
	   }

	   .information .btn {
		 margin-top: 10px;
	   }

	  /* End profile page */

	  /* Start show item page */

	  .item-info h2 {
		padding:10px;
		margin:0;
	  }

	  .item-info p {
		padding:10px;
	  }

	  .item-info ul li {
		padding: 10px;
	  }

	  .item-info ul li:nth-child(odd) {
		background-color: #e8e8e8;
	  }

	  .item-info ul li span {
		display: inline-block;
		width: 120px;
	  }
	  
	  .tags-items a {
		  display: inline-block;
		  background-color:#e2e2e2;
		  padding:2px 10px;
		  border-radius:5px;
		  color:#666;
		  margin-right:5px;
	  }

	  .add-comment h3 {
		margin:0 0 10px;
	  }

	  .add-comment textarea {
		display: block;
		margin-bottom: 10px;
		width:500px;
		height:120px;
	  }

	  .comment-box {
		margin-bottom: 20px;
	  }

	  .comment-box img{
		max-width: 100px;
		margin-bottom: 10px;
	  }

	  .comment-box .lead {
		background-color: #e0e0e0;
		position: relative;
		padding:10px;
		margin-top: 25px;
	  }

	  .comment-box .lead:before {
		content: "";
		width: 0;
		height: 0;
		border-width: 15px;
		border-style: solid;
		border-color: transparent #e0e0e0 transparent transparent;
		position: absolute;
		left: -28px;
		top: 10px;
	  }

	  /* End show item page */

	  /* Start our custom */
	  .custom-hr {
		border-top: 1px solid #c9c9c9;
	  }
	  /* End our custom */
	  
	 </style>
  </head>
<body>
  <div class="upper-bar">
     <div class="container">
       <?php
          if (isset($_SESSION['user'])) { ?>

            <img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
            <div class="btn-group my-info">
                <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <?php echo $sessionUser ?>
                      <span></span>
                </span>
                <ul class="dropdown-menu">
                  <li><a href="profile.php">My profile</a></li>
                  <li><a href="newad.php">New item</a></li>
                  <li><a href="profile.php#my-ads">My items</a></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

            <?php

          } else {
       ?>
       <a href="login.php">
           <span class="pull-right">Login/Signup</span>
       </a>
     <?php } ?>
     </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="index.php"> Homepage </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav navbar-right">

        <?php

        //$categories = getCat();

        $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID_cat","ASC");

        foreach ($allCats as $cat) {

          echo
          '<li class="nav-item">
              <a class="nav-link" href="categories.php?pageid=' . $cat['ID_cat'] . '">
              ' . $cat['Name'] . '
              </a>
          </li>';
        }

        ?>



      </ul>
    </div>
  </div>
  </nav>
