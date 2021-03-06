
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
  $view_cnt = 8;            // 1ページの表示件数

  // データの件数から最大ページを計算する
  // SQLで計算するデータを取得
  $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `kami_shops`';
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




$sql = "SELECT * FROM `kami_shops` ORDER BY `modified` DESC LIMIT ".$st.",".$view_cnt."";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  while(true) {
  $kami_shop = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($kami_shop == false) {
         break;
      }
      
    //   var_dump($kami_shop);
    // exit;
  $review_sql = 'SELECT * FROM `kami_reviews` WHERE `shop_id`=? ORDER BY `review_created` DESC LIMIT 1';
  $review_data = array($kami_shop['shop_id']);
  $review_stmt = $dbh->prepare($review_sql);
  $review_stmt->execute($review_data);
  $review = $review_stmt->fetch(PDO::FETCH_ASSOC);
  $kami_shop['review'] = $review['review'];
  $kami_shops[] = $kami_shop;
  //   var_dump($kami_shops);
  // exit();
    }


  //SQL(テーブルから列を抽出する
  $keigo =@$_GET['shop'];

  if (strlen($keigo)>0){
  $search_sql ="SELECT * FROM `kami_shops`";
  //キーワードが入力されているときはwhere以下を組み立てる
    //受け取ったキーワードの全角スペースを半角スペースに変換する
    $text2 = str_replace("　", " ", $keigo);

    //キーワードを空白で分割する
    $array = explode(" ",$text2);

    //分割された個々のキーワードをSQLの条件where句に反映する
    $where = "WHERE ";

   for($i = 0; $i < count($array);$i++){
      $where .= "(shop_name_abc LIKE '%$array[$i]%' OR shop_name collate utf8_unicode_ci LIKE '%$array[$i]%' OR shop_type LIKE '%$array[$i]%')";
      if ($i <count($array) -1){
        $where .= " AND ";
      }
     }
     // var_dump($search_sql);exit;
    $search_sql = $search_sql . ' ' . $where;
    // var_dump($search_sql);exit;

    $search_stmt = $dbh->prepare($search_sql);
    $search_stmt->execute();
    $kami_search_shops = array();

    while(true) {
      $kami_search_shop = $search_stmt->fetch(PDO::FETCH_ASSOC);
    if ($kami_search_shop == false) {
         break;
      }
  $review_sql = 'SELECT * FROM `kami_reviews` WHERE `shop_id`=? order by `created` desc limit 1';
  $review_data = array($kami_search_shop['shop_id']);
  $review_stmt = $dbh->prepare($review_sql);
  $review_stmt->execute($review_data);
  $review_search = $review_stmt->fetch(PDO::FETCH_ASSOC);
  $kami_search_shop['review'] = $review_search['review'];
      $kami_search_shops[] = $kami_search_shop;
    }

      //  var_dump($kami_search_events);
      // // exit();
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
  <title>お店一覧</title>
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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/jquery.scrollme.js"></script>

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
   <section id="bricks" class="with-top-sep">
     <div class="container">
      <div class="row current-cat">
         <div class="col-xs-4 col-md-3 col-lg-2" >
                   </div>
         <div class="col-xs-7 col-md-8 col-lg-9" style="padding-bottom: 0;">
            <h1 style="font-weight: 900; margin-bottom: -30px; text-align: center;">お店一覧<?php 
           if(!empty($_GET['shop'])){
             echo "：";
             echo $_GET['shop']; }?></h1>
         </div>         
          <div class="col-xs-1 col-md-1 col-lg-1" >
                   </div>
      </div>
    </div>
          <div class="comments-wrap">

            <div id="comments" class="row">
                <div class="col-full">
               <!-- commentlist -->
               <ol class="commentlist2" style="padding: 30px;">
    <?php if (!empty($_GET['shop'])) { ?>
      <?php for ($i=0; $i<count($kami_search_shops);$i++){ ?>

   <li class="depth-1 scrollme animateme" data-when="enter" data-from="0.5" data-to="0" data-crop="false" data-opacity="0" data-scale="1.5" >

                   <div class="container">
         <div class="row">
                     <div class="col-xs-1 col-md-1 col-lg-1" >
                   </div>
                   <div class="col-xs-9 col-md-9 col-lg-9">
             <div class="row">
              <div class="" style="height: 240px; width: 1000px">
                   <div class="col-xs-3 col-md-3 col-lg-3" >
                     <div class="avatar" style="margin-top: 0rem; height: 20rem">
                        <img class="avatar" src="shop_pic/<?php echo $kami_search_shops[$i]['shop_pic']; ?>" alt="" style="width: 100%; object-fit: cover; object-position: center; height: 20rem">
                     </div>
                  </div>
                  <div class="col-xs-9 col-md-9 col-lg-9" >
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite><a href="store_details.php?name=<?php echo $kami_search_shops[$i]["shop_name"]; ?>&name_abc=<?php echo $kami_search_shops[$i]["shop_name_abc"]; ?>"><?php echo $kami_search_shops[$i]["shop_name_abc"]; ?>(<?php echo $kami_search_shops[$i]["shop_name"]; ?>)</a></cite>
                            
                         </div>
                         <div class="comment-text">
                            <p>ジャンル：<?php echo $kami_search_shops[$i]["shop_type"]; ?><br>
                            最新のレビュー：<?php echo $kami_search_shops[$i]["shop_name"]; ?>
                            </p>
                         </div>
                      </div>
                  </div>
              </div>
            <hr style="padding-top: 0px; margin-top: -44px;">
            </div>
          </div>
  <div class="col-xs-2 col-md-2 col-lg-2" >
                   </div>
                 </div>
               </div>
                  </li>
                 <?php } ?>
  <?php } else { ?>
  <?php for ($i=0; $i<count($kami_shops);$i++){ ?>
   <li class="depth-1 scrollme animateme" data-when="enter" data-from="0.5" data-to="0" data-crop="false" data-opacity="0" data-scale="1.5" >
                   <div class="container">
         <div class="row">
            <div class="col-xs-1 col-md-1 col-lg-1" >
                   </div>
                   <div class="col-xs-9 col-md-9 col-lg-9">
             <div class="row">
              <div class="" style="height: 240px; width: 1000px">
                   <div class="col-xs-3 col-md-3 col-lg-3">
                     <div class="avatar" style="margin-top: 0rem; width: 100%; height: 20rem;">
                        <img width="50" height="50" class="avatar" src="shop_pic/<?php echo $kami_shops[$i]['shop_pic']; ?>" alt="" style="width: 100%; object-fit: cover; object-position: center; height: 20rem">
                     </div>
                  </div>
                  <div class="col-xs-9 col-md-9 col-lg-9">
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite><a href="store_details.php?name=<?php echo $kami_shops[$i]["shop_name"]; ?>&name_abc=<?php echo $kami_shops[$i]["shop_name_abc"]; ?>"><?php echo $kami_shops[$i]["shop_name_abc"]; ?>(<?php echo $kami_shops[$i]["shop_name"]; ?>)</a></cite>
                            
                         </div>
                         <div class="comment-text">
                            <p>ジャンル：<?php echo $kami_shops[$i]["shop_type"]; ?><br>
                            最新のレビュー：<?php echo $kami_shops[$i]["review"]; ?>
                            </p>
                         </div>
                      </div>
                  </div>
              </div>
               <hr style="padding-top: 0px; margin-top: -44px;">
            </div>
          </div>
  <div class="col-xs-2 col-md-2 col-lg-2" >
                   </div>
                 </div>
               </div>
                  </li>

          <?php } ?>
    <?php } ?>
 

            
               </ol> <!-- Commentlist End -->                  
               <!-- respond -->
              
            </div> <!-- end col-full -->
         </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->


        
               <nav class="pagination">
            <?php if($page == 1) { ?>
            <span class="page-numbers prev inactive">Prev</span>
            <?php } else { ?>
            <a href="shop_list.php?page=<?php echo $page -1; ?>"><span class="page-numbers prev">Prev</span></a>
            <?php } ?>
            <?php for($start; $start <= $end; $start++): ?>
            <li><a href="shop_list.php?page=<?= ($start) ?>" <?= ($start == $page)? 'class="current"' : '' ?> class="page-numbers"><?= $start ?></a></li>
            <?php endfor; ?>
            <?php if($page == $all_view_cnt) { ?>
            <span class="page-numbers inactive">Next</span>
            <?php } else {  ?>
            <a href="shop_list.php?page=<?php echo $page +1; ?>" class="page-numbers next">Next</a>
            <?php } ?>
         </nav>
   </section> <!-- bricks -->

   
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
   <script src="js/modal.js"></script>
</body>

</html>