<?php 
require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');


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
  $view_cnt = 9;            // 1ページの表示件数

  // データの件数から最大ページを計算する
  // SQLで計算するデータを取得
  $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `kami_events` WHERE `answer_limitation`>NOW()';
  $page_stmt = $dbh->prepare($page_sql);
  $page_stmt->execute();

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
  $page_pos = 0;             // 該当ページ表示位置

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
$sql = "SELECT * FROM `kami_events`  WHERE `answer_limitation`>NOW() ORDER BY `answer_limitation` ASC LIMIT ".$st.",".$view_cnt."";
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
   // var_dump($kami_events);

$sql = "SELECT * FROM (`kami_reviews` LEFT JOIN `kami_members` ON `kami_reviews`.`member_id`=`kami_members`.`member_id`) LEFT JOIN `kami_shops` ON `kami_reviews`.`shop_id`=`kami_shops`.`shop_id` ORDER BY `review_created` DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while(true) {
$kami_review = $stmt->fetch(PDO::FETCH_ASSOC);
if ($kami_review == false) {
   break;
}
$kami_reviews[] = $kami_review;
}
     // var_dump($kami_reviews);
 ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
   <title>home</title>
   <meta name="description" content="">  
   <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/home_base.css">
   <link rel="stylesheet" href="css/vendor.css">  
   <link rel="stylesheet" href="css/modal.css">  

   

   <link rel="stylesheet" href="css/home_bootstrap.css">
   <link rel="stylesheet" href="css/home_main.css">
   <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


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

<?php 
require('header.php');
?>



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

                                 <h1 class="slide-title">セブでの食事を楽しくするサービス</h1> 
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

                                 <h1 class="slide-title">行きたいお店がすぐに見つかる</h1>
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

                                 <h1 class="slide-title">あなたの食事をマッチング</h1>
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
                     <h1 class="sintyaku" style="margin: 0 253px 44px; border-bottom: double 5px #FFC778;">締め切り間近のイベント</h1>


         <div class="row">

  <?php for ($i=0; $i<count($kami_events);$i++){ ?>
    <?php if (strtotime(date('Y-m-d H:i')) < strtotime($kami_events[$i]["answer_limitation"])) { ?>
     <?php if ($kami_events[$i]["graduation"]==0) { ?>

         <div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this" style="background-color: white; height: 800px; overflow: auto;">

               <div class="entry-thumb">
                  <a href="#" class="thumb-link">
                     <img src="event_picture/<?php echo $kami_events[$i]['event_picture'] ?>" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_events[$i]["answer_limitation"])); ?>
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.php?id=<?php echo $kami_events[$i]["event_id"]; ?>"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.php?name=<?php echo $kami_events[$i]["event_place"]; ?>&name_abc=<?php echo $kami_events[$i]["event_place"]; ?>"><?php echo $kami_events[$i]["event_place"]; ?></a><br>
                     開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
                   <!--   <div class="text_overflow1"> -->
                     詳細<br>
                     <?php echo $kami_events[$i]["detail"]; ?>
                    <!--  </div> -->


                  </div>
               </div>

            </article> <!-- end article -->
</div>
<?php }else{ ?>

  <div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this" style="background-color: #F5A9A9; height: 800px; overflow: auto;">

               <div class="entry-thumb">
                  <a href="#" class="thumb-link">
                     <img src="event_picture/<?php echo $kami_events[$i]["event_picture"]; ?>" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_events[$i]["answer_limitation"])); ?>
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.php?id=<?php echo $kami_events[$i]["event_id"]; ?>"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.php?name=<?php echo $kami_events[$i]["event_place"]; ?>&name_abc=<?php echo $kami_events[$i]["event_place"]; ?>"><?php echo $kami_events[$i]["event_place"]; ?></a><br>
                     開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
                     参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
                   <!--   <div class="text_overflow1"> -->
                     詳細<br>
                     <?php echo $kami_events[$i]["detail"]; ?>
                    <!--  </div> -->

                  </div>
               </div>

            </article> <!-- end article -->
</div>
            <?php } ?>
      <?php } ?>
    <?php } ?>

   </div>
</div>

<div class="col-xs-3 col-md-3 col-lg-3 review" >
   <ol class="commentlist box17" style="padding: 30px; background-color: white;">
      <h1 class="sintyaku" style="color: black;/*文字色*/
padding: 0.3em 0;/*上下の余白*/
border-top: solid 2px #FFC778;/*上線*/
border-bottom: solid 2px #FFC778;/*下線*/
margin-bottom: 30px">新着レビュー</h1>

                  
<section class="quotes" style="height:900px">

</section>

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
             <li><a href="home.php?page=<?= ($start) ?>" <?= ($start == $page)? 'class="current"' : '' ?> class="page-numbers"><?= $start ?></a></li>
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
   <script src="js/main.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/modal.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
   <script src="js/foldscroll.js"></script>
   <script src="js/quotes.js"></script>
   <script type="text/javascript">
$(function() {
        var limit = 15;
        var $container = $( '.quotes' );

                // Populate
<?php for ($i=0; $i<count($kami_reviews);$i++){ ?>
    $container.append(
'<li class="depth-1">'+
 '<div class="row" style="margin:10px;">'+
  '<div class="col-xs-２ col-md-2 col-lg-2" style="text-align: left;">'+
   '<a href="ProfileOther.php?id=<?php echo $kami_reviews[$i]["member_id"]; ?>">'+
    '<div class="avatar">'+
      '<img src="picture_path/<?php echo $kami_reviews[$i]["picture_path"]; ?>" alt="building">'+
    '</div>'+
   '</a>'+
  '</div>'+
  '<div class="col-xs-8 col-md-8 col-lg-8" style="padding-bottom: 0;">'+
   '<a href="store_details.php?name=<?php echo $kami_reviews[$i]["shop_name"]; ?>&name_abc=<?php echo $kami_reviews[$i]["shop_name_abc"]; ?>">'+
    '<?php echo $kami_reviews[$i]["shop_name_abc"]; ?>(<?php echo $kami_reviews[$i]["shop_name"]; ?>)'+
   '</a>'+
  '</div>'+
  '<div class="col-xs-2 col-md-2 col-lg-2">'+
  '</div>'+
 '</div>'+
 '<div class="comment-content">'+
  '<div class="comment-info">'+
   '<div class="comment-meta">'+
    '<time class="comment-time">'+
     '<?php echo $kami_reviews[$i]["review_created"]; ?>'+
    '</time>'+
   '</div>'+
  '</div>'+
  '<div class="comment-text">'+
   '<p class="text_overflow2">'+
    '<?php echo $kami_reviews[$i]["review"]; ?>'+
   '</p>'+
   '<hr>'+
  '</div>'+
 '</div>'+
'</li>');
<?php } ?>


  // Call the foldscroll plugin
  $container.foldscroll({
    perspective: 900,
    // margin: '220px'
  });
});

            </script>
   <script>

     Push.Permission.request();

function alert1() {
<?php for ($i=0; $i<count($tsuuti_events);$i++){ ?>
  <?php if ($tsuuti_events[$i]['min']<=$tsuuti_events[$i]['join_count']): ?>
    Push.create('KAMI', {
　　body: 'イベント <?php  
  echo $tsuuti_events[$i]["event_name"] ?>が成立しました！',
　　icon: 'images/logo2.png',
　　timeout: 8000, // 通知が消えるタイミング
　　vibrate: [100, 100, 100], // モバイル端末でのバイブレーション秒数
　　   onClick: function() {
　　　　   // 通知がクリックされた場合の設定
　　　　    console.log(this);
　　           }
  });
 <?php endif ?>
<?php } ?>
};
setTimeout(alert1, 300);

    $(function() {
    var count = 250;
 $('.text_overflow1').each(function() {
     var thisText = $(this).text();
      var textLength = thisText.length;
       if (textLength > count) {
            var showText = thisText.substring(0, count);
            var hideText = thisText.substring(count, textLength);
           var insertText = showText;
          insertText += '<span class="hide">' + hideText + '</span>';
           insertText += '<span class="omit">…</span>';
            insertText += '<a href="" class="more">もっと見る</a>';
            $(this).html(insertText);
       };
  });
 $('.text_overflow1 .hide').hide();
 $('.text_overflow1 .more').click(function() {
      $(this).hide()
          .prev('.omit').hide()
         .prev('.hide').fadeIn();
      return false;
   });
});
$(function() {
    var count = 120;
 $('.text_overflow2').each(function() {
     var thisText = $(this).text();
      var textLength = thisText.length;
       if (textLength > count) {
            var showText = thisText.substring(0, count);
            var hideText = thisText.substring(count, textLength);
           var insertText = showText;
          insertText += '<span class="hide">' + hideText + '</span>';
           insertText += '<span class="omit">…</span>';
            insertText += '<a href="" class="more">もっと見る</a>';
            $(this).html(insertText);
       };
  });
 $('.text_overflow2 .hide').hide();
 $('.text_overflow2 .more').click(function() {
      $(this).hide()
          .prev('.omit').hide()
         .prev('.hide').fadeIn();
      return false;
   });
});
</script>

</body>

</html>