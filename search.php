<?php  
session_start();
if (isset($_GET)) {
    
if ($_GET["list"] == 'event'){
  header('Location: eventItiran.php?event='.$_GET['s']);
  exit();
}elseif ($_GET["list"] == 'omise') {

  header('Location: shop_list.php?shop='.$_GET['s']);
  exit();
}
}


?>