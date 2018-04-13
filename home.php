<?php 
require('function.php');
  login_check();

 require('dbconnect.php');

  // ページング機能
  // 空の変数を用意
  $page = '';

  // パラメータが存在していたらページ番号を代入
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  // 1以下のイレギュラーな数字が入ってきた時、ページ番号を強制的に1とする
  // max カンマ区切りで羅列された数字の中から最大の数字を取得する
  $page = max($page, 1);

  // 1ページ分の表示件数を指定
  $view_cnt = 12;            // 1ページの表示件数

  // データの件数から最大ページを計算する
  // SQLで計算するデータを取得
  $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `kami_events`';
  $page_stmt = $dbh->prepare($page_sql);
  $page_stmt->execute();

  // 全件取得(論理削除されていないもの)
  $page_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

  // ceil 小数点切り上げ
  // 1~5 1ページ 6~10 2ページ...
  $all_view_cnt = ceil($page_count['page_count'] / $view_cnt);

  // パラメータのページ番号が最大ページを超えていれば、強制的に最後のページとする
  // min カンマ区切りで羅列された数字の中から最小の数字を取得する
  $page = min($page, $all_view_cnt);

  // 表示するデータの取得開始場所
  $st = ($page - 1) * $view_cnt;

  $page_num = 10;            // 表示ページ数
$page_end = $page_num - 1; // 末ベージ数計算用
$page_pos = 5;             // 該当ページ表示位置



$start = 0; // 開始ページ
$end = 0;   // 末ページ

// 開始ページの計算
if ($all_view_cnt <= $page_num) {
    $start = 1;  
} else {
    $start = (($page - $page_pos) > 1)? $page - $page_pos : 1;
    // 終了ページが最大超になる場合
    if ($start + $page_end > $all_view_cnt) {
        $start = $all_view_cnt - $page_end; 
    }
}

// 末ページの計算
$end = ($all_view_cnt <= $page_num)? $all_view_cnt : $start + $page_end;

 // var_dump($_GET);
 // exit();
 $sql = "SELECT * FROM `kami_events` ORDER BY `modified` DESC LIMIT ".$st.",".$view_cnt."";
    $stmt = $dbh->prepare($sql);
      $stmt->execute();
      while(true) {
      $kami_event = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($kami_event == false) {
         break;
      }
    $join_sql = 'SELECT COUNT(*) AS `join_count` FROM `kami_event_joinings` WHERE `event_id`=?';
    $join_data = array($kami_event['event_id']);
    $join_stmt = $dbh->prepare($join_sql);
    $join_stmt->execute($join_data);

    $join_count = $join_stmt->fetch(PDO::FETCH_ASSOC);

    // 一行分のデータに新しいキーを用意し、$join_countを代入
    $kami_event['join_count'] = $join_count['join_count'];

     $kami_events[] = $kami_event;
     }

     $sql = "SELECT * FROM (`kami_reviews` LEFT JOIN `kami_members` ON `kami_reviews`.`member_id`=`kami_members`.`member_id`) LEFT JOIN `kami_shops` ON `kami_reviews`.`shop_id`=`kami_shops`.`shop_id` ORDER BY `review_created` DESC LIMIT 5";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      while(true) {
      $kami_review = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($kami_review == false) {
         break;
      }
     $kami_reviews[] = $kami_review;
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
   <title>Abstract</title>
   <meta name="description" content="">  
   <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/home_base.css">
   <link rel="stylesheet" href="css/vendor.css">  
   

   <link rel="stylesheet" href="css/home_bootstrap.css">
   <link rel="stylesheet" href="css/home_main.css">


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
               <li class="current"><a href="home.php" title="">ホーム</a></li>   
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



   <!-- masonry
   ================================================== -->
   <section id="bricks">
      <div class="masonry">
         <!-- brick-wrapper -->
         <div class="bricks-wrapper">

            <div class="grid-sizer"></div>

            <div class="brick entry featured-grid animate-this">
               <div class="entry-content">
                  <div id="featured-post-slider" class="flexslider">
                     <ul class="slides">

                        <li>
                           <div class="featured-post-slide">

                              <div class="post-background" style="background-image:url('images/pizza-table.jpg');"></div>

                              <div class="overlay"></div>                  

                              <div class="post-content">
                                 <ul class="entry-meta">
                                    <li>kami</li> 
                                    <li><a href="#" >team pelo</a></li>           
                                 </ul> 

                                 <h1 class="slide-title"><a href="single-standard.html" title="">セブでの食事を楽しくするサービス</a></h1> 
                              </div>                                
                        
                           </div>
                        </li> <!-- /slide -->

                        <li>
                           <div class="featured-post-slide">

                              <div class="post-background" style="background-image:url('images/breakfast-diet.jpg');"></div>

                              <div class="overlay"></div>                  

                              <div class="post-content">
                                 <ul class="entry-meta">
                                    <li>kami</li>
                                    <li><a href="#">team pelo</a></li>
                                 </ul> 

                                 <h1 class="slide-title"><a href="single-standard.html" title="">行きたいお店がすぐに見つかる</a></h1>
                              </div>                                         
                        
                           </div>
                        </li> <!-- /slide -->

                        <li>
                           <div class="featured-post-slide">

                              <div class="post-background" style="background-image:url('images/crayfish.jpg');"></div>

                              <div class="overlay"></div>                  

                              <div class="post-content">
                                 <ul class="entry-meta">
                                    <li>kami</li>
                                    <li><a href="#" class="author">team pelo</a></li>               
                                 </ul> 

                                 <h1 class="slide-title"><a href="single-standard.html" title="">あなたの食事をマッチング</a></h1>
                              </div>

                           </div>
                        </li> <!-- end slide -->

                     </ul> <!-- end slides -->
                  </div> <!-- end featured-post-slider -->                 
               </div> <!-- end entry content -->               
            </div>
         </div>
      </div>
      
      <div class="container">
         <div class="row">
                  <div class="col-xs-9 col-md-9 col-lg-9">
                     <h1 class="sintyaku">締め切り間近のイベント</h1>


         <div class="row">

  <?php for ($i=0; $i<count($kami_events);$i++){ ?>
     <?php if ($kami_events[$i]["graduation"]==0) { ?>

         <div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="event_picture/<?php echo $kami_events['event_picture']; ?>" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_events[$i]["answer_limitation"])); ?>
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.php?name=<?php echo $kami_events[$i]["event_place"]; ?>"><?php echo $kami_events[$i]["event_place"]; ?></a><br>
                     開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
                     詳細<br>
                     <?php echo $kami_events[$i]["detail"]; ?>


                  </div>
               </div>

            </article> <!-- end article -->
</div>
<?php }else{ ?>

  <div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="event_picture/<?php echo $kami_events['event_picture']; ?>" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_events[$i]["answer_limitation"])); ?>
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.php?name=<?php echo $kami_events[$i]["event_place"]; ?>"><?php echo $kami_events[$i]["event_place"]; ?></a><br>
                     開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
                     詳細<br>
                     <?php echo $kami_events[$i]["detail"]; ?>


                  </div>
               </div>

            </article> <!-- end article -->
</div>
            <?php } ?>
   <?php } ?>


         
    <!-- </div> end colサイズ指定  -->
   </div>
</div>
             <div class="col-xs-3 col-md-3 col-lg-3 review" >

<ol class="commentlist">
            <h1 class="sintyaku">新着レビュー</h1>

                  

  <?php for ($i=0; $i<count($kami_reviews);$i++){ ?>

                  <li class="depth-1">

                     <div class="avatar">
                        <img src="picture_path/<?php echo $reviews['picture_path']; ?>" alt="building">
                     </div>

                     <div class="comment-content">

                        <div class="comment-info">
                           <cite><a href="store_details.php?name=<?php echo $kami_reviews[$i]["shop_name"]; ?>"><?php echo $kami_reviews[$i]["shop_name_abc"]; ?>(<?php echo $kami_reviews[$i]["shop_name"]; ?>)</a></cite>

                           <div class="comment-meta">
                              <time class="comment-time" datetime="2014-07-12T25:15">July 12, 2014 @ 25:15</time>
                            
                           </div>
                        </div>

                        <div class="comment-text">
                           <p><?php echo $kami_reviews[$i]["review"]; ?></p>
                        </div>

                     </div>

                  </li>
               <?php } ?>

               </ol>
            </div>
         </div> <!-- end brick-wrapper --> 
      </div><!-- end row -->
   </div><!-- end container -->

    <!-- <div class="row"> -->
         
         
               <nav class="pagination">
            <?php if($page == 1) { ?>
            <span class="page-numbers prev inactive">Prev</span>
            <?php } else { ?>
            <a href="home.php?page=<?php echo $page -1; ?>"><span class="page-numbers prev">Prev</span></a>
            <?php } ?>
            <?php for($start; $start <= $end; $start++): ?>
            <li <?= ($start == $page)? 'class="current"' : '' ?>><a href="home.php?page=<?= ($start) ?>" class="page-numbers"><?= $start ?></a></li>
            <?php endfor; ?>
            <?php if($page == $all_view_cnt) { ?>
            <span class="page-numbers inactive">Next</span>
            <?php } else {  ?>
            <a href="home.php?page=<?php echo $page +1; ?>" class="page-numbers next">Next</a>
            <?php } ?>
         </nav>

      <!-- </div> -->

   </section> <!-- end bricks -->

   
   <!-- footer
   ================================================== -->
   <footer>

                 


             
                  <p class="keigo"><span>© kami 2018</span> 
                  <span>by team pelo</a></span></p>              
             

                <!-- end footer-bottom -->  

   </footer>  

   <div id="preloader"> 
      <div id="loader"></div>
   </div> 

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/jquery.appear.js"></script>
   <script src="js/main.js"></script>
   <script src="js/bootstrap.js"></script>

</body>

</html>