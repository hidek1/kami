<?php 
// function.phpを読み込み
require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');

 // ログインユーザー情報取得
$sql = 'SELECT * FROM `kami_members` WHERE `member_id`=?';
  $data = array($_SESSION['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  // データ一件取得 (レコードを取得)
  $profile = $stmt->fetch(PDO::FETCH_ASSOC);


  $sql = 'SELECT * FROM `kami_event_joinings` LEFT JOIN `kami_events` ON `kami_event_joinings`.`event_id`=`kami_events`.`event_id` WHERE `member_id`=?';
  $data = array($profile['member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

   while(true) {
      $event_joining = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($event_joining);
//       exit();
    if ($event_joining == false) {
         break;
      }
    $join_sql = 'SELECT COUNT(*) AS `join_count` FROM `kami_event_joinings` WHERE `event_id`=?';
    $join_data = array($event_joining['event_id']);
    $join_stmt = $dbh->prepare($join_sql);
    $join_stmt->execute($join_data);

    $join_count = $join_stmt->fetch(PDO::FETCH_ASSOC);

    // 一行分のデータに新しいキーを用意し、$join_countを代入
    $event_joining['join_count'] = $join_count['join_count'];
    $event_joinings[] = $event_joining;
    }


  $sql = 'SELECT * FROM `kami_reviews` LEFT JOIN `kami_shops` ON `kami_reviews`.`shop_id`=`kami_shops`.`shop_id` WHERE `member_id`=?';
  $data = array($profile['member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  while(true) {
  $review = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($review == false) {
         break;
      }
      $reviews[] = $review;
    }




 ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>Profile</title>
  <meta name="description" content="">  
  <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/base.css">
   <link rel="stylesheet" href="css/vendor.css">  
   <link rel="stylesheet" href="css/profile_profileedit_main.css">
   <link rel="stylesheet" href="css/ange_bootstrap.css">


   <!-- script
   ================================================== -->
  <script src="js/modernizr.js"></script>
  <script src="js/pace.min.js"></script>

   <!-- favicons
  ================================================== -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body id="top" style="background-color: whitesmoke;">



  <?php 
  require('header.php');
  ?>

  <section id="page-header">
    <center>
      <h1>Profile</h1>
    </center>
  </section>
  <center>
    <h1><?php echo $profile['nickname']; ?></h1>
  </center>
  <center>
   <img src="picture_path/<?php echo $profile['picture_path']; ?>" width="200" height="200" alt="building" style="border-radius: 100%;">
  </center>
  <div class="container">
    <div class="row">
     <div class="col-xs-3 col-md-3 col-lg-3">
     </div>
     <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
      <p>Room Number : <?php echo $profile['room_number']; ?> </p>
     </div>
     <div class="col-xs-3 col-md-3 col-lg-3">
     </div>
    </div>
  </div>
  <div class="container">
   <div class="row">
    <div class="col-xs-3 col-md-3 col-lg-3">
    </div>
    <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
    <p>Length of Stay : <?php echo $profile['stay_start']; ?>〜<?php echo $profile['stay_finish']; ?></p>
    </div>
    <div class="col-xs-3 col-md-3 col-lg-3">
    </div>
   </div>
  </div>
  <div class="container">
   <div class="row">
    <div class="col-xs-3 col-md-3 col-lg-3">
    </div>
    <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
      <p>Comment : <?php echo $profile['comment']; ?></p>
    </div>
    <div class="col-xs-3 col-md-3 col-lg-3">
    </div>
   </div>
  </div>
  <center>
   <a href="ProfileEdit.php" title=""><button type="button" class="submit button-primary">Profile Edit</button></a>
  </center>
                      
  <section id="page-header">
   <center>
    <h1>参加予定</h1>
   </center>
  </section>
  <!-- masonry
  ================================================== -->
  <section id="bricks" class="with-top-sep">
  </section>
  <div class="container">
    <div class="row">
     <?php if (isset($event_joinings)) {?>
      <?php for ($i=0; $i<count($event_joinings);$i++){ ?>
       <?php if (strtotime(date('Y-m-d H:i')) < strtotime($event_joinings[$i]["starttime"])) { ?>
        <div class="col-xs-4 col-md-4 col-lg-4">
         <article class="brick entry format-standard animate-this" style="height: 700px; overflow: auto; background-color: white;">
          <div class="entry-thumb">
           <a href="eventView.php?id=<?php echo $event_joinings[$i]["event_id"]; ?>" class="thumb-link">
            <?php if (!empty($event_joinings[$i]["event_picture"])){ ?>
             <img src="event_picture/<?php echo $event_joinings[$i]["event_picture"]; ?>" alt="building">
            <?php }else{ ?>
            <?php } ?>             
           </a>
          </div>
          <div class="entry-text">
           <div class="entry-header">
            <div class="entry-meta">
             <span class="cat-links">
             </span>     
            </div>
             <h1 class="entry-title"><a href="eventView.php?id=<?php echo $event_joinings[$i]["event_id"]; ?>"><?php echo $event_joinings[$i]['event_name']; ?></a></h1>
           </div>
           <div class="entry-excerpt">
             開催場所: <a href="store_details.php?name=<?php echo $event_joinings[$i]["event_place"]; ?>&name_abc=<?php echo $event_joinings[$i]["event_place"]; ?>"><?php echo $event_joinings[$i]["event_place"]; ?></a><br>
             開催日: <?php echo date('n月j日' , strtotime($event_joinings[$i]["starttime"])); ?><br>
             開始時間:　<?php echo date('H時i分' , strtotime($event_joinings[$i]["starttime"])); ?><br>
             参加予定人数 <?php echo $event_joinings[$i]["join_count"]; ?>人/<?php echo $event_joinings[$i]["max"]; ?>人<br>
             <div class="text_overflow1">
             詳細<br>
             <?php echo $event_joinings[$i]["detail"]; ?>
             </div>
           </div>
          </div>
         </article> <!-- end article -->
        </div>
       <?php } ?>             
      <?php } ?>
     <?php } ?>
    </div>
  </div>




   <section id="page-header">
    <center>
     <h1>REVIEW</h1>
    </center>
   </section>

   
   <!-- masonry
   ================================================== -->
   <section id="bricks" class="with-top-sep">
   </section>

   <div class="container">
    <div class="row">
     <?php if (isset($reviews)) {?>
      <?php for ($i=0; $i<count($reviews);$i++){ ?>
       <div class="col-xs-4 col-md-4 col-lg-4">
        <article class="brick entry format-standard animate-this" style="height: 600px; overflow: auto; background-color: white;">
         <div class="entry-thumb">
          <a href="store_details.php?name=<?php echo $reviews[$i]["shop_name"]; ?>&name_abc=<?php echo $reviews[$i]["shop_name_abc"]; ?>" class="thumb-link">
           <?php if (!empty($reviews[$i]['review_picture'])){ ?>
            <img src="review_picture/<?php echo $reviews[$i]['review_picture']; ?>" alt="building">
           <?php }else{ ?>
            <img src="review_picture/01.jpg" alt="building">
           <?php } ?>             
          </a>
         </div>
         <div class="entry-text">
          <div class="entry-header">
           <div class="entry-meta">
            <span class="cat-links">
            </span>     
           </div>
           <h1 class="entry-title"><a href="store_details.php?name=<?php echo $reviews[$i]["shop_name"]; ?>&name_abc=<?php echo $reviews[$i]["shop_name_abc"]; ?>"><?php echo $reviews[$i]['shop_name_abc']; ?>(<?php echo $reviews[$i]['shop_name']; ?>)</a></h1>
          </div>
          <div class="entry-excerpt">
             <?php echo $reviews[$i]['review']; ?>
          </div>
         </div>
        </article> <!-- end article -->
       </div>
      <?php } ?>
     <?php } ?>
    </div>
   </div>
   <center>
    <footer>
     <p class="keigo"><span>© kami 2018</span> 
      <span>by team pelo</a></span>
     </p>              
             
    </footer>  
   </center>
   <div id="preloader">
    <div id="loader"></div>
   </div> 

   

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script>
   <script src="js/modal.js"></script>
</body>

</html>