<?php

require('dbconnect.php');
session_start();

// var_dump($_SESSION);exit;


// echo "<br>";
// echo "<br>";echo "<br>";

// echo $_GET['id'];

// var_dump($_GET['id']);


$sql = 'SELECT * FROM `kami_shops` WHERE `shop_name`=?';
$data = array($_GET['name']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$store_info = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($store_info);
// exit();

$review_pic = array();

// ポスト送信された時
if (!empty($_POST)) {

if ($_POST['review']=='') {
  $error['review'] = 'blank';
}

if (!isset($error)) {

// 写真４枚挿入したい。
for ($i=0; $i < 4; $i++) {

  $ext = substr($_FILES['picture']['name'][$i], -3);
  $ext = strtolower($ext);
  if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
    $review_pic['picture']['name'][$i] = date('YmdHis') . $_FILES['picture']['name'][$i];
    move_uploaded_file($_FILES['picture']['tmp_name'][$i] , 'review_picture/'.$review_pic['picture']['name'][$i]);
  }
}

  $store_review = htmlspecialchars($_POST['review']);

// var_dump($review_pic['picture']['name']);
// exit();

  $sql = 'INSERT INTO `kami_reviews` SET `shop_id` =?, `member_id`=?, `review`=?, `review_picture`=?, `review_picture2` =?, `review_picture3`=?, `review_picture4`=?, `review_created`=NOW(), `modified`=NOW()';
  
  $data = array($store_info['shop_id'], $_SESSION['id'], $store_review, $review_pic['picture']['name'][0], $review_pic['picture']['name'][1], $review_pic['picture']['name'][2], $review_pic['picture']['name'][3]);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  header('Location: store_details.php?name=' . $store_info['shop_name']);
  exit();

 }
}


// else {
//   header();
//   exit;
// }


 ?>



 <!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>レビュー投稿</title>
  <meta name="description" content="">
  <meta name="author" content="">

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

   <!-- favicons
  ================================================== -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body id="top">

   <!-- header
   ================================================== -->
   <header class="short-header">

      <div class="gradient-block"></div>

      <div class="row header-content">

         <div class="logo">
            <a href="index.html">Author</a>
         </div>

         <nav id="main-nav-wrap">
            <ul class="main-navigation sf-menu">
               <li class="has-children"><a href="home.php" title="">ホーム</a></li>
               <li class="has-children"><a href="eventNew.php" title="">イベント作成</a></li>
               <li class="has-children"><a href="store_review.php" title="">お店を投稿する</a></li>

               <li class="has-children">
                  <a href="eventItiran.php" title="">イベント一覧</a>
               </li>
               <li class="has-children">
                  <a href="shop_list.php" title="">お店一覧</a>
               </li>
       <li class="has-children">
                  <a href="Profile.php" title="">マイページ</a>
               </li>
                <li class="has-children">
                  <a href="logout.php" title="">ログアウト</a>
               </li>
            </ul>
         </nav> <!-- end main-nav-wrap -->

         <div class="search-wrap">
            <form role="search" method="get" class="search-form" action="search.php">
               <label>
                  <span class="hide-content">Search for:</span>
                   <select class="search-select" name="list">
                    <option value="event" selected>イベントを探す</option>
                     <option value="omise">店を探す</option>
                      </select>
                  <input type="search" class="search-field" placeholder="Type Your Keywords" value="" name="s" title="Search for:" autocomplete="off">

               </label>
               <input type="submit" class="search-submit" value="Search">

            </form>


            <a href="#" id="close-search" class="close-btn">Close</a>

         </div> <!-- end search wrap -->

         <div class="triggers">
            <a class="search-trigger" href="#"><i class="fa fa-search"></i></a>
            <a class="menu-toggle" href="#"><span>Menu</span></a>
         </div> <!-- end triggers -->

      </div>


   </header> <!-- end header -->

   <!-- content
   ================================================== -->
   <section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">

        <section>

          <!-- <div class="content-media">
            <div id="map-wrap">
              <div id="map-container"></div>
                <div id="map-zoom-in"></div>
              <div id="map-zoom-out"></div>
            </div>  
          </div> -->

          <div class="primary-content">

            <h1 class="entry-title add-bottom">レビュー投稿</h1>

            <p class="lead">あなたのオススメをNexseedのみんなにシェアしよう！</p>

            </div>
            <br>
            <form name="cForm" id="cForm" method="post" action="" enctype="multipart/form-data">
                 <fieldset>
                       <div><h1 class="entry-title add-bottom">店名: <?php echo $store_info['shop_name_abc']; ?></h1></div>
                       <br><br><br>

                       <div><h1>レビュー</h1></div>
                       <div class="message form-field">
                          <textarea name="review" id="cMessage" class="full-width" placeholder="（例）セブに来て、こんなに料理の美味しい店は初めてです。特にBird's Nest Soupが最高です。これを食べずして「セブに行ったよ！」なんて言おうものなら末代まで笑われます。" ></textarea>
                       </div>

                       <br>
                       <br>
                       <br>
                       <br>

                       <span class="retty-btn fileinput-button fileinput-button-mypage">
                       <div class="add_files"><h1>写真（最大４枚まで）</h1></div>
                       <input id="fileupload_file" type="file" name="picture[]" multiple="">
                       <input id="fileupload_file" type="file" name="picture[]" multiple="">
                       <input id="fileupload_file" type="file" name="picture[]" multiple="">
                       <input id="fileupload_file" type="file" name="picture[]" multiple="">


                      </span>

                       <br>
                       <br>
                       <br>
                       <br>
                       <br>

                     
                       <button type="submit" class="submit button-primary full-width-on-mobile"><center>投稿</center></button>
                       </div>

                 </fieldset>
                </form> <!-- end form -->

        </section>
      

      </div> <!-- end col-twelve -->
    </div> <!-- end row -->   
   </section> <!-- end content -->

   
   <!-- footer
   ================================================== -->

<footer>
             <center>

                  <p class="keigo"><span>© kami 2018</span>
                  <span>by team pelo</a></span></p>
            </center>
                <!-- end footer-bottom -->
   </footer>

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="http://maps.google.com/maps/api/js?v=3.13&amp;sensor=false"></script>
   <script src="js/main.js"></script>

</body>

</html>