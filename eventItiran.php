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
  $view_cnt = 12;            // 1ページの表示件数

  // データの件数から最大ページを計算する
  // SQLで計算するデータを取得
  $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `kami_events` WHERE `answer_limitation`>NOW()';
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
$sql = "SELECT * FROM `kami_events` WHERE `answer_limitation`>NOW() ORDER BY `answer_limitation` ASC LIMIT ".$st.",".$view_cnt."";
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

  //SQL(テーブルから列を抽出する
$keigo =@$_GET['event'];

if (strlen($keigo)>0){
  $search_sql ="SELECT * FROM `kami_events`";
  //キーワードが入力されているときはwhere以下を組み立てる
    //受け取ったキーワードの全角スペースを半角スペースに変換する
  $text2 = str_replace("　", " ", $keigo);

    //キーワードを空白で分割する
  $array = explode(" ",$text2);

    //分割された個々のキーワードをSQLの条件where句に反映する
  $where = "WHERE ";

  for($i = 0; $i < count($array);$i++){
    $where .= "(`answer_limitation`>NOW() AND event_name collate utf8_unicode_ci LIKE '%$array[$i]%' OR detail collate utf8_unicode_ci LIKE '%$array[$i]%')";
    if ($i <count($array) -1){
      $where .= " AND ";
    }
  }
     // var_dump($search_sql);exit;
  $search_sql = $search_sql . ' ' . $where;
    // var_dump($search_sql);exit;

  $search_stmt = $dbh->prepare($search_sql);
  $search_stmt->execute();
  $kami_search_events = array();

  while(true) {
    $kami_search_event = $search_stmt->fetch(PDO::FETCH_ASSOC);
    if ($kami_search_event == false) {
     break;
   }
   $join_sql = 'SELECT COUNT(*) AS `join_search_count` FROM `kami_event_joinings` WHERE `event_id`=?';
   $join_data = array($kami_search_event['event_id']);
   $join_stmt = $dbh->prepare($join_sql);
   $join_stmt->execute($join_data);

   $join_search_count = $join_stmt->fetch(PDO::FETCH_ASSOC);
   $kami_search_event['join_search_count'] = $join_search_count['join_search_count'];
   $kami_search_events[] = $kami_search_event;
 }

      //  var_dump($kami_search_events);
      // // exit();
}
 // }



?>



<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

   <!--- basic page needs
     ================================================== -->
     <meta charset="utf-8">
     <title>イベント一覧</title>
     <meta name="description" content="">  
     <meta name="author" content="">

   <!-- mobile specific metas
     ================================================== -->
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- CSS
     ================================================== -->
     <link rel="stylesheet" href="css/home_base.css">
     <link rel="stylesheet" href="css/vendor.css">  
     

     
     <link rel="stylesheet" href="css/eventItiran_main.css">


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


   <!-- page header
     ================================================== -->
     

     
   <!-- masonry
     ================================================== -->
     <section id="bricks" class="with-top-sep">
      <center>
        <div class="row current-cat">
         <div class="col-full">
          <h1>イベント一覧<?php 
          if(!empty($_GET['event'])){
           echo "：";
           echo $_GET['event']; }?></h1>
           
         </div>         
       </div>
     </center>
     

     <div class="row masonry">

      <!-- brick-wrapper -->
      <div class="bricks-wrapper">

        <div class="grid-sizer"></div>

        <?php if (!empty($_GET['event'])) { ?>
        <?php for ($i=0; $i<count($kami_search_events);$i++){ ?>
        <?php if (strtotime(date('Y-m-d H:i')) < strtotime($kami_search_events[$i]["answer_limitation"])) { ?>

          <?php if ($kami_search_events[$i]["graduation"]==0) { ?>
          <article class="brick entry format-standard animate-this">

           <div class="entry-thumb">
            <a href="eventView.php?id=<?php echo $kami_search_events[$i]["event_id"]; ?>" class="thumb-link">
             <img src="event_picture/<?php echo $kami_search_events[$i]['event_picture']; ?>" alt="building" alt="Pattern">             
           </a>
         </div>

         <div class="entry-text">
          <div class="entry-header">

           <div class="entry-meta">
            <span class="cat-links">
              回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_search_events[$i]["answer_limitation"])); ?>
              
            </span>        
          </div>
          
          <h1 class="entry-title"><a href="eventView.php?id=<?php echo $kami_search_events[$i]["event_id"]; ?>"><?php echo $kami_search_events[$i]["event_name"]; ?></a></h1>
          
        </div>
        <div class="entry-excerpt">
         開催場所: <a href="store_details.php?name=<?php echo $kami_search_events[$i]["event_place"]; ?>"><?php echo $kami_search_events[$i]["event_place"]; ?></a><br>
         開催日: <?php echo date('n月j日' , strtotime($kami_search_events[$i]["starttime"])); ?><br>
         開始時間:　<?php echo date('H時i分' , strtotime($kami_search_events[$i]["starttime"])); ?><br>
         参加予定人数 <?php echo $kami_search_events[$i]["join_search_count"]; ?>人/<?php echo $kami_search_events[$i]["max"]; ?>人<br>
         <div class="text_overflow1">

           詳細<br>
           <?php echo $kami_search_events[$i]["detail"]; ?>
         </div>
       </div>
     </div>

   </article> <!-- end article -->
   <?php }else{ ?>
   <article class="brick entry format-standard animate-this">

     <div class="entry-thumb">
      <a href="eventView.php?id=<?php echo $kami_search_events[$i]["event_id"]; ?>" class="thumb-link">
       <img src="event_picture/<?php echo $kami_search_events[$i]['event_picture']; ?>" alt="building" alt="Pattern">             
     </a>
   </div>

   <div class="entry-text" style="background-color: #F5A9A9;">
    <div class="entry-header">

     <div class="entry-meta">
      <span class="cat-links">
        回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_search_events[$i]["answer_limitation"])); ?>
        
      </span>        
    </div>
    
    <h1 class="entry-title"><a href="eventView.php?id=<?php echo $kami_search_events[$i]["event_id"]; ?>"><?php echo $kami_search_events[$i]["event_name"]; ?></a></h1>
    
  </div>
  <div class="entry-excerpt">
   開催場所: <a href="store_details.php?name=<?php echo $kami_search_events[$i]["event_place"]; ?>"><?php echo $kami_search_events[$i]["event_place"]; ?></a><br>
   開催日: <?php echo date('n月j日' , strtotime($kami_search_events[$i]["starttime"])); ?><br>
   開始時間:　<?php echo date('H時i分' , strtotime($kami_search_events[$i]["starttime"])); ?><br>
   参加予定人数 <?php echo $kami_search_events[$i]["join_search_count"]; ?>人/<?php echo $kami_search_events[$i]["max"]; ?>人<br>
   <div class="text_overflow1">

     詳細<br>
     <?php echo $kami_search_events[$i]["detail"]; ?>
   </div>

 </div>
</div>

</article> <!-- end article -->
<?php } ?>
<?php } ?>
<?php } ?>
<?php } else { ?>
<?php for ($i=0; $i<count($kami_events);$i++){ ?>
<?php if (strtotime(date('Y-m-d H:i')) < strtotime($kami_events[$i]["answer_limitation"])) { ?>
 <?php if ($kami_events[$i]["graduation"]==0) { ?>
 <article class="brick entry format-standard animate-this">

   <div class="entry-thumb">
    <a href="eventView.php?id=<?php echo $kami_events[$i]["event_id"]; ?>" class="thumb-link">
     <img src="event_picture/<?php echo $kami_events[$i]['event_picture']; ?>" alt="building" alt="Pattern">             
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
 開催場所: <a href="store_details.php?name=<?php echo $kami_events[$i]["event_place"]; ?>"><?php echo $kami_events[$i]["event_place"]; ?></a><br>
 開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
 開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
 参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
 <div class="text_overflow1">
   詳細<br>
   <?php echo $kami_events[$i]["detail"]; ?>
 </div>
</div>
</div>

</article> <!-- end article -->
<?php }else{ ?>
<article class="brick entry format-standard animate-this">

 <div class="entry-thumb">
  <a href="eventView.php?id=<?php echo $kami_events[$i]["event_id"]; ?>" class="thumb-link">
   <img src="event_picture/<?php echo $kami_events[$i]['event_picture']; ?>" alt="building" alt="Pattern">             
 </a>
</div>

<div class="entry-text" style="background-color: #F5A9A9;">
  <div class="entry-header">

   <div class="entry-meta">
    <span class="cat-links">
     回答期限：<?php echo date('n月j日H時i分' , strtotime($kami_events[$i]["answer_limitation"])); ?>
     
   </span>        
 </div>
 
 <h1 class="entry-title"><a href="eventView.php?id=<?php echo $kami_events[$i]["event_id"]; ?>"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
 
</div>
<div class="entry-excerpt">
 開催場所: <a href='store_details.php?name=<?php  echo $kami_events[$i]["event_place"]; ?>'><?php echo $kami_events[$i]["event_place"]; ?></a><br>
 開催日: <?php echo date('n月j日' , strtotime($kami_events[$i]["starttime"])); ?><br>
 開始時間:　<?php echo date('H時i分' , strtotime($kami_events[$i]["starttime"])); ?><br>
 参加予定人数 <?php echo $kami_events[$i]["join_count"]; ?>人/<?php echo $kami_events[$i]["max"]; ?>人<br>
 <div class="text_overflow1">

   詳細<br>
   <?php echo $kami_events[$i]["detail"]; ?>
 </div>
</div>
</div>

</article> <!-- end article -->
<?php } ?>
<?php } ?>

<?php } ?>
<?php } ?>

</div> <!-- end brick-wrapper --> 

</div> <!-- end row -->

<div class="row">
  
  <nav class="pagination">
    <?php if($page == 1) { ?>
    <span class="page-numbers prev inactive">Prev</span>
    <?php } else { ?>
    <a href="eventItiran.php?page=<?php echo $page -1; ?>"><span class="page-numbers prev">Prev</span></a>
    <?php } ?>
    <?php for($start; $start <= $end; $start++): ?>
      <li><a href="eventItiran.php?page=<?= ($start) ?>" <?= ($start == $page)? 'class="current"' : '' ?> class="page-numbers"><?= $start ?></a></li>
    <?php endfor; ?>
    <?php if($page == $all_view_cnt) { ?>
    <span class="page-numbers inactive">Next</span>
    <?php } else {  ?>
    <a href="shop_list.php?page=<?php echo $page +1; ?>" class="page-numbers next">Next</a>
    <?php } ?>
  </nav>
</div>

</section> <!-- bricks -->


   <!-- footer
     ================================================== -->
     <footer>

       


       <center>
        <p class="keigo"><span>© kami 2018</span> 
          <span>by team pelo</a></span></p>              
        </center>

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
     <script src="js/modal.js"></script>
     <script>$(function() {
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
  </script>
</body>

</html>