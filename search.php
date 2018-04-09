<?php  
session_start();
if (isset($_GET)) {
    $_SESSION['s'] = $_GET['s'];
if ($_GET["list"] == 'event'){
  header('Location: eventItiran.php');
  exit();
}elseif ($_GET["list"] == 'omise') {
  header('Location: shop_list.php');
  exit();
}
}


?>