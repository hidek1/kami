<?php
require('dbconnect.php');
$sql = 'SELECT * FROM `kami_shops`';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
   while(true) {
  $shop = $stmt->fetch(PDO::FETCH_ASSOC);
if ($shop == false) {
         break;
      }
$shops[] = $shop;
    }
// echo '<pre>';
// var_dump($shops);exit;
// echo '</pre>';
$shops_name = array();

for ($i=0; $i < count($shops); $i++) {
    // var_dump($shops[0]);exit;
  $shops_name[] = $shops[$i]["shop_name_abc"];
  $shops_name[] = $shops[$i]["shop_name"];

}
// $a = array(
//   'HPI',
//   'Kyosho',
//   'Losi',
//   'Tamiya',
//   'Team Associated',
//   'Team Durango',
//   'Traxxas',
//   'Yokomo'
// );


$b = array();

if($_POST['param1']){
  $w = $_POST['param1'];  
  foreach($shops_name as $i){
    if(stripos($i, $w) !== FALSE){
      $b[] = $i;
    } 
  }
  echo json_encode($b);
}
else{
  echo json_encode($b);
}
?>