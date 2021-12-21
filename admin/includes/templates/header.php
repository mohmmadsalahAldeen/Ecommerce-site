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
  }

  .asterisk {
    font-size: 30px;
    position: absolute;
    right: 28px;
    top: 10px;
    color:red;
  }

  .nice-message {
    padding: 10px;
    background-color: #FFF;
    margin: 10px 0;
    border-left: 5px solid #080;
  }

  /* end main rulez */

  /* START LOGIN FORM */

  .login {
    width : 300px;
    margin: 100px auto;
  }

  .login input {
    margin-bottom: 10px;
  }

  .login .form-control {
    background-color: #EAEAEA;
  }

  .login .btn {
    background-color: #008dde
  }
  /* end login form */


  /* start bootstrap edits */
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
  /* end bootstrap edits */

  /* Start Dashboard page */

  .home-stats .stat {
    padding: 20px;
    font-size: 15px;
    color:#FFF;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
  }

  .home-stats .stat i {
    position: absolute;
    font-size: 80px;
    top: 35px;
    left: 30px;
  }

  .home-stats .stat .info {
    float:right;
  }

  .home-stats .stat a {
    color:#FFF;
  }

  .home-stats .stat a:hover {
    text-decoration: none;
  }

  .home-stats .stat span {
    display: block;
    font-size: 60px;
  }

  .home-stats .st-members {
    background-color: #3498db;
  }

  .home-stats .st-pending {
    background-color: #c0392b;
  }

  .home-stats .st-items {
    background-color: #d35400;
  }

  .home-stats .st-comments {
    background-color: #8e44ad;
  }

  .latest {
    margin-top: 40px;
  }

  .latest .toggle-info {
    color: #999;
    cursor: pointer;
  }

  .latest-users {
    margin-bottom: 0;
  }

  .latest-users li {
    padding: 5px 0;
    overflow: hidden;
  }

  .latest-users li:nth-child(odd) {
    background-color: #EEE;
  }

  .latest-users .btn-success ,
  .latest-users .btn-info {
    padding: 3px 8px;
  }

  .latest-users .btn-info {
    margin-right: 5px;
  }

  .latest .comment-box {
    margin: 5px 0 10px;
  }

  .latest .comment-box .member-n,
  .latest .comment-box .member-c {
    float: left;
  }

  .latest .comment-box .member-n {
    width: 80px;
    text-align: center;
    margin-right: 20px;
    position: relative;
    top:5px;
  }

  .latest .comment-box .member-c {
    width: calc(100% - 100px);
    background-color: #EFEFEF;
    padding: 10px;
    position: relative;
  }

  .latest .comment-box .member-c:before {
    content: "";
    display: block;
    position: absolute;
    left: -28px;
    top:   5px;
    width:0;
    height:0;
    border-style: solid;
    border-color: transparent #EFEFEF transparent transparent;
    border-width: 15px;
  }

  /* End Dashboard page */

  /* start member page */

  h1 {
    font-size: 55px;
    margin: 40px 0;
    font-weight: bold;
    color: #666;
  }

  .show-pass {
    position: absolute;
    top:6px;
    right:-30px;
  }

  .main-table {
    -webkit-box-shadow: 0 3px 10px #CCC;
    -moz-box-shadow: 0 3px 10px #CCC;
    box-shadow: 0 3px 10px #CCC;
  }

  .main-table td {
    background-color: #FFF;
    vertical-align: middle !important;
  }

  .main-table tr:first-child td { /* you can use thead */
    background-color: #333;
    color: #FFF;
  }

  .main-table .btn {
     padding: 3px 10px;
  }
  /* end member page */

  /* start Category page */

  .categories .panel-heading {
    color: #959595;
    font-weight: bold;
  }

  .categories .panel-heading i {
    position: relative;
    top:1px;
  }

  .categories .panel-body {
    padding: 0;
  }

  .categories .option a {
    color:#888;
    text-decoration: none;
  }

  .categories .option span {
    color:#888;
    cursor: pointer;
  }

  .categories .option .active {
    color:#F00;
  }

  .categories hr {
    margin-top: 0;
    margin-bottom: 0;
  }

  .categories .cat {
    padding:15px;
    position: relative;
    overflow: hidden;
  }

  .categories .cat:hover {
    background-color: #EEE;
  }

  .categories .cat:hover .hidden-buttons {
    right: 10px;
  }

  .categories .cat .hidden-buttons {
    -webkit-transition:all .5s ease-in-out;
    -moz-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
    position: absolute;
    top: 15px;
    right: -120px;
  }

  .categories .cat .hidden-buttons a {
    margin-right: 5px;
  }

  .categories .cat h3 {
    margin: 0;
    cursor: pointer;
    font-weight: bold;
    color: #6A6A6A;
  }

  .categories .cat .full-view p {
    margin: 10px 0;
    color:#707070;
  }

  .categories .cat:last-of-type ~ hr {
    display: none;
  }

  .categories .cat .visibility {
    background-color: #c0392b;
    color:#FFF;
    padding:4px 6px;
    margin-right: 5px;
    border-radius: 6px;
  }

  .categories .cat .commenting {
    background-color: #2c3e50;
    color:#FFF;
    padding: 4px 6px;
    margin-right: 5px;
    border-radius: 6px;
  }

  .categories .cat .adverties {
    background-color: #c0392b;
    color:#FFF;
    padding: 4px 6px;
    margin-right: 5px;
    border-radius: 6px;
  }

  .categories .add-category {
    margin-top: -10px;
    margin-bottom: 30px;
  }

  .categories .child-head {
    margin: 15px 0;
    font-weight: bold;
    font-size: 16px;
    color: #22ab79;
  }

  .categories .child-cats {
    margin : 10px 0 10px 20px;
  }

  .categories .child-cats li {
    margin-left: 20px;
  }

  .categories .child-cats li:before {
    content: "- ";
  }

  .categories .show-delete {
    color: #F00;
    display: none;
  }
  /* End Category page */

  </style>
  </head>
<body>
