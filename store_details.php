<?php 
require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');
// echo '<br>'; echo '<br>';echo '<br>';
// echo $_GET['name'];

// ORDER BY `shop_id` DESC LIMIT 1

$sql = 'SELECT * FROM `kami_shops` LEFT JOIN `kami_reviews` ON `kami_shops` . `shop_id` = `kami_reviews` . `shop_id` WHERE `shop_name`=? or `shop_name_abc`=?';
$data = array($_GET['name'],$_GET['name_abc']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$store_detail = $stmt->fetch(PDO::FETCH_ASSOC);


// var_dump($store_detail);


// echo "<br>";echo "<br>";echo "<br>";
// var_dump($_GET['id']);

// }

$sql = 'SELECT * FROM `kami_reviews` LEFT JOIN `kami_members` ON `kami_reviews` . `member_id` = `kami_members` . `member_id` WHERE `shop_id`=? ORDER BY `review_created` DESC';
$data = array($store_detail['shop_id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// 写真表示（４枚全部入っている時と、入っていない時）
$records = array();
$pictures = array();
while (true) {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  if($record["review_picture"] != ''){
  $pictures[] = $record["review_picture"];
  }
  if($record["review_picture2"] != ''){
  $pictures[] = $record["review_picture2"];
  }
  if($record["review_picture3"] != ''){
  $pictures[] = $record["review_picture3"];
  }
  if($record["review_picture4"] != ''){
  $pictures[] = $record["review_picture4"];
  }
  if($record == false){
    break;
  }
  $records[] = $record;
}

// echo '<pre>';
// var_dump($records);
// echo '</pre>';
// exit;

$count = count($records);
// $dbh = null;



 ?>

<!DOCTYPE html>

<html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>お店詳細</title>
  <meta name="description" content="">
  <meta name="author" content="">
<!--  -->
   <!-- mobile specific metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/321_base.css">
   <link rel="stylesheet" href="css/vendor.css">
   <link rel="stylesheet" href="css/321_main.css">

   <!-- script
   ================================================== -->
  <script src="js/modernizr.js"></script>
  <script src="js/pace.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="js/slick-1.8.0/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="js/slick-1.8.0/slick/slick-theme.css"/>

   <!-- favicons
  ================================================== -->
  <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
<link rel="stylesheet" href="css/lightbox.css">
<style>
#map{
  width: 850px;
  height: 400px;
}
#dist-label{
  color: #2E9AFE;
}
</style> 
</head>

<body id="top">


<?php 
require('header.php');
?>
   <!-- content
   ================================================== -->
   <div id="link1"></div>
   <section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">

        <section>
         <br>
          <br>
          <img src="shop_pic/<?php echo $store_detail['shop_pic']; ?>" width="200" height="300" style="margin-top: -2rem; margin-right: 0px;margin-bottom: -19rem;">
           <div class="primary-content">
            <h1 class="entry-title add-bottom" style="margin-left: 26rem;"><?php echo $store_detail['shop_name_abc']; ?>
             <br>
              (<?php echo $store_detail['shop_name']; ?>)
            </h1>
             <p>ジャンル：<?php echo $store_detail['shop_type']; ?></p>

<!-- ナビバー -->
          <a href="review.php?name=<?php echo $store_detail['shop_name']; ?>">
            <button type="submit" class="submit button-primary">
            投稿
            </button>
          </a>
          <a href="#link2">
            <button type="submit" class="submit button-primary">
             写真
            </button>
          </a>
          <a href="#link3">
            <button type="submit" class="submit button-primary">
              レビュー
            </button>
          </a>
          <a href="#link4">
            <button type="submit" class="submit button-primary">
              アクセス
            </button>
          </a>
          <a href="store_review_edit.php?name=<?php echo $store_detail['shop_name']; ?>" title="">
            <button type="submit" class="submit button-primary">
             編集
            </button>
          </a>

            <div id="link2" style="margin-top: 100px;">
             <h1></h1>
            </div>
            <div class="slider">
             <?php foreach ($pictures as $pic) { ?>
              <div>
               <a href="review_picture/<?php echo $pic?>" data-lightbox="sample"><img src="review_picture/<?php echo $pic?>" alt="投稿写真" style="padding: 0px 50px; height: 430px; width: 100%;object-fit: cover;"></a>
              </div>
             <?php } ?>
            </div>

            <div id="link3">
             <h1 style="margin-top: 70px;" ></h1>
            </div>

            <div class="comments-wrap">
             <div id="comments" class="row">
              <div class="col-full">
               <ol class="commentlist">
                 <?php for ($i=0; $i < $count; $i++) { ?>
                <li class="depth-1">

                    <div class="comment-content">
                     <div class="comment-info">
<!-- レビュー投稿 -->
                     <img width="50" height="50" class="avatar" src="picture_path/<?php echo $records[$i]['picture_path']; ?>" alt="">
                      <div>nickname (<?php echo $records[$i]['nickname']; ?>)</div>
                       <div class="comment-meta">
                        <a href="Profile.php?member_id=<?php echo $records[$i]['member_id']; ?>" style="font-size: 16px;"><span class="name">nickname (<?php echo $records[$i]['nickname']; ?>)</span></a>
                        <time class="comment-time" datetime="2014-07-12T23:05"><?php echo date('Y/m/d',strtotime($records[$i]['review_created']));?></time>
                          </div>
                        </div>
                          <div class="comment-text">
                           <p>レビュー <br> <?php echo $records[$i]['review']; ?></p>
                            <table cellpadding="0" cellspacing="30"><tbody>
                             <tr>
                              <?php if ($records[$i]['review_picture'] != ''): ?>
                               <td>
                                <a href="review_picture/<?php echo $records[$i]['review_picture']; ?>" data-lightbox="sample"><img src="review_picture/<?php echo $records[$i]['review_picture']; ?>" width="150" height="150" alt=""></a>
                              </td>
                               <?php endif ?>
                                <?php if ($records[$i]['review_picture2'] != ''): ?>
                                 <td>
                                  <a href="review_picture/<?php echo $records[$i]['review_picture2']; ?>" data-lightbox="sample"><img src="review_picture/<?php echo $records[$i]['review_picture2']; ?>" width="150" height="150" alt=""></a>
                              </td>
                              <?php endif ?>
                              <?php if ($records[$i]['review_picture3'] != ''): ?>
                               <td>
                                <a href="review_picture/<?php echo $records[$i]['review_picture3']; ?>" data-lightbox="sample"><img src="review_picture/<?php echo $records[$i]['review_picture3']; ?>" width="150" height="150" alt=""></a>
                              </td>
                              <?php endif ?>
                              <?php if ($records[$i]['review_picture4'] != ''): ?>
                              <td>
                               <a href="review_picture/<?php echo $records[$i]['review_picture4']; ?>" data-lightbox="sample"><img src="review_picture/<?php echo $records[$i]['review_picture4']; ?>" width="150" height="150" alt=""></a>
                              </td>
                              <?php endif ?>
                              </tr>
                             </tbody>
                            </table>
                           </div>
                          </div>
                         </li>
                          <hr>
                           <?php } ?>
                       </ol>
                      </div>
                     </div>
                      <div id="link4">
                       <h1></h1>
                      </div>
                       <br>
                       <div class="content-media">
                        <div id="map-wrap">
                            <div id="map"></div>
                        </div>
                       </div>
                       <div align="center">
                         <a href="#link1">TOP</a>
                       </div>
                      </section>
                     </div>
                    </div>
                   </section>

   <!-- footer
   ================================================== -->

<footer>
                  <div align="center">
                  <p class="keigo"><span>© kami 2018</span>
                  <span>by team pelo</a></span></p>
                  </div>

                <!-- end footer-bottom -->
   </footer>
   <div id="preloader">
      <div id="loader"></div>
   </div> 

   <!-- Java Script
   ================================================== -->
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpUu08GcFO2jItVjyR9lxweWq7lKiRgWc&callback=initMap"></script>
        <script>

      function initMap() {
              var infowindow1 = new google.maps.InfoWindow({
        content: '<?php echo $store_detail['shop_name_abc'] ?>',
      })
              var infowindow2 = new google.maps.InfoWindow({
        content: '寮'
      })
                  infowindow1.open(map, marker);
        var shop = {lat: <?php echo $store_detail['lat'] ?>, lng: <?php echo $store_detail['lng'] ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: shop
        });
      var dormitory = {lat: 10.329092, lng: 123.903811};
       var dormitory_marker = new google.maps.Marker({
       position: dormitory,
       map: map,
       content: '寮'
       });
        var marker = new google.maps.Marker({
          position: shop,
          map: map,
          content: '<p id="dist-label"><?php echo $store_detail['shop_name_abc'] ?></p>',
        });
       //寮などのわかりやすくするための表示(特に必須ではない)
             infowindow1.open(map, marker);
}
   </script>
   <script src="js/main.js"></script>
   <!-- <script src="js/slick.min.js"></script> -->
   <script src="js/modal.js"></script>
   <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="js/slick-1.8.0/slick/slick.min.js"></script>
 <script>
      $('.slider').slick({
         dots: true,
  infinite: true,
  speed: 500,
  fade: true,
  cssEase: 'linear'
      });

  </script>

   <script src="js/lightbox.min.js"></script>
   <script src="js/lightbox-plus-jquery.min.js"></script>
   <script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
</body>

</html>