<?php

/*
** Get all function v2.0
** Function to get all records from any database table
*/

function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfiled, $ordering = "DESC") {

  global $con;

  $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfiled $ordering");

  $getAll->execute();

  $all = $getAll->fetchAll();

  return $all;

}

/*
** Get ad items function v2.0
** Function to get ad items from database
*/

function getItems($where, $value, $approve = NULL) {

  global $con;

  $sql = $approve == NULL ? 'AND approve = 1' : '';

  $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY ID_item DESC");

  $getItems->execute(array($value));

  $items = $getItems->fetchAll();

  return $items;

}

/*
** Check if user is not activated
** Function to check the regstatus of the user
*/

function checkUserStatus($user) {

  global $con;

  $stmtx = $con->prepare("SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0");

  $stmtx->execute(array($user));

  $status = $stmtx->rowCount();

  return $status;

}



// title function that echo the page title in case the page

// has the variable $pageTitle and echo default title for other pages

function getTitle() {

  global $pageTitle;

  if(isset($pageTitle)) {

    echo $pageTitle;

  } else {

    echo 'Default';

  }
}

/*
** Home redirect function v2.0
** this function accept parameters
** $theMsg = Echo the message [ Error | Success | warning ]
** $url = The link you want to redirect to
** $seconds = seconds before redirecting
*/

function redirectHome($theMsg, $url = null, $seconds = 3) {

  if ($url === null) {

    $url = 'index.php';

    $link = 'Homepage';

  } else {

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

      $url = $_SERVER['HTTP_REFERER'];

      $link = 'Previous page';

    } else {

      $url = 'index.php';

      $link = 'Homepage';

    }

  }

  echo $theMsg;

  echo "<div class='alert alert-info'>You will be redirected to $link after $seconds seconds.</div>";

  header("refresh:$seconds;url=$url");

  exit();
}

/*
** Check items function v1.0
** Function to check item in database [Function accept parameter ]
** $select = the item to select [ example :user, items, categories ]
** $form = the table to select from [ example : users, items,categories ]
** $value = the value of select [example : osama, box, electronics ]
*/

function checkItem($select, $from, $value) {

  global $con;

  $statement = $con->prepare("SELECT $select FROM $from Where $select = ?");

  $statement->execute(array($value));

  $count = $statement->rowCount();

  return $count;
}

/*
** count number of items function v1.0
** function to count number of items rows
** $item = the item to count
** $table = the table to choose from
*/

function countItems($item, $table) {

  global $con;

  $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

  $stmt2->execute();

  return $stmt2->fetchColumn();
}

/*
** Get latest records function v1.0
** Function to get latest items from database [ Users, Items, Comments ]
** $select = field to select
** $table = the table to choose from
** $order = the desc Ordering
** $limit = number of records to get
*/

function getLatest($select, $table, $order, $limit = 5) {

 global $con;

 $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

 $getStmt->execute();

 $rows = $getStmt->fetchAll();

 return $rows;

}
?>
