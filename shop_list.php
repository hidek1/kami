
<?php 
require('function.php');
  login_check();

 require('dbconnect.php');
$sql = 'SELECT * FROM `kami_shops`';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  while(true) {
  $kami_shop = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($kami_shop == false) {
         break;
      }
      
    //   var_dump($kami_shop);
    // exit;
  $review_sql = 'SELECT * FROM `kami_reviews` WHERE `shop_id`=?order by `created` desc limit 1';
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
  $search_sql ="SELECT * FROM `kami_shops` LEFT JOIN `kami_reviews` ON `kami_shops`.`shop_id`=`kami_reviews`.`shop_id`";
  //キーワードが入力されているときはwhere以下を組み立てる
    //受け取ったキーワードの全角スペースを半角スペースに変換する
    $text2 = str_replace("　", " ", $keigo);

    //キーワードを空白で分割する
    $array = explode(" ",$text2);

    //分割された個々のキーワードをSQLの条件where句に反映する
    $where = "WHERE ";

   for($i = 0; $i < count($array);$i++){
      $where .= "(shop_name_abc LIKE '%$array[$i]%' OR shop_name LIKE '%$array[$i]%' OR shop_type LIKE '%$array[$i]%')";
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
  $review_sql = 'SELECT * FROM `kami_reviews` WHERE `shop_id`=?order by `created` desc limit 1';
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
  $page_number = 5;

  // データの件数から最大ページを計算する
  // SQLで計算するデータを取得
  $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `tweets` WHERE `delete_flag`=0';
  $page_stmt = $dbh->prepare($page_sql);
  $page_stmt->execute();

  // 全件取得(論理削除されていないもの)
  $page_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

  // ceil 小数点切り上げ
  // 1~5 1ページ 6~10 2ページ...
  $all_page_number = ceil($page_count['page_count'] / $page_number);

  // パラメータのページ番号が最大ページを超えていれば、強制的に最後のページとする
  // min カンマ区切りで羅列された数字の中から最小の数字を取得する
  $page = min($page, $all_page_number);

  // 表示するデータの取得開始場所
  $start = ($page - 1) * $page_number;
 ?>




<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>Category Page - Abstract</title>
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
               <li class="has-children"><a href="home.php" title="">ホーム</a></li>   
               <li class="has-children"><a href="eventNew.php" title="">イベント作成</a></li>                          
               <li class="has-children"><a href="store_review.php" title="">お店を投稿する</a></li>                          

               <li class="has-childrens">
                  <a href="eventItiran.php" title="">イベント一覧</a>
               </li>
               <li class="current">
                  <a href="shop_list.php" title="">お店</a>
               </li>
       <li class="has-childrens">
                  <a href="Profile.php" title="">マイページ</a>
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


   <!-- page header
   ================================================== -->
  

   
   <!-- masonry
   ================================================== -->
   <section id="bricks" class="with-top-sep">
      <center>

      <div class="row current-cat">
         <div class="col-full">
            <h1>お店一覧<?php 
           if(!empty($_GET['shop'])){
             echo "：";
             echo $_GET['shop']; }?></h1>
         </div>         
      </div>
       </center>
          <div class="comments-wrap">

            <div id="comments" class="row">
                <div class="col-full">
                  <center>
               <!-- commentlist -->
               <ol class="commentlist2">
    <?php if (!empty($_GET['shop'])) { ?>
      <?php for ($i=0; $i<count($kami_search_shops);$i++){ ?>

                    <li class="depth-1">
                   <div class="container">
         <div class="row">
                   <div class="col-xs-2 col-md-2 col-lg-2" >
                   </div>
                   <div class="col-xs-2 col-md-2 col-lg-2" >
                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/shaka3.jpg" alt="">
                     </div>
                  </div>
                  <div class="col-xs-6 col-md-6 col-lg-6" >
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite><a href="#"><?php echo $kami_search_shops[$i]["shop_name_abc"]; ?>(<?php echo $kami_search_shops[$i]["shop_name"]; ?>)</a></cite>
                            
                         </div>
                         <div class="comment-text">
                            <p>ジャンル：<?php echo $kami_search_shops[$i]["shop_type"]; ?><br>
                            最新のレビュー：<?php echo $kami_search_shops[$i]["shop_name"]; ?>
                            </p>
                         </div>
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
   <li class="depth-1">
                   <div class="container">
         <div class="row">
                   <div class="col-xs-2 col-md-2 col-lg-2" >
                   </div>
                   <div class="col-xs-2 col-md-2 col-lg-2" >
                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/shaka3.jpg" alt="">
                     </div>
                  </div>
                  <div class="col-xs-6 col-md-6 col-lg-6" >
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite><a href="#"><?php echo $kami_shops[$i]["shop_name_abc"]; ?>(<?php echo $kami_shops[$i]["shop_name"]; ?>)</a></cite>
                            
                         </div>
                         <div class="comment-text">
                            <p>ジャンル：<?php echo $kami_shops[$i]["shop_type"]; ?><br>
                            最新のレビュー：<?php echo $kami_shops[$i]["review"]; ?>
                            </p>
                         </div>
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
               </center>                   
               <!-- respond -->
              
            </div> <!-- end col-full -->
         </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->
                                 
                          
               <nav class="pagination">
            <?php if($page == 1) { ?>
            <span class="page-numbers prev inactive">Prev</span>
            <?php } else { ?>
            <li><a href="eventItiran.php?page=<?php echo $page -1; ?>"><span class="page-numbers prev inactive">Prev</span></a></li>
            <?php } ?>
            <span class="page-numbers current">1</span>
            <a href="shop_list.php?page=2" class="page-numbers">2</a>
            <a href="shop_list.php?page=3" class="page-numbers">3</a>
            <a href="shop_list.php?page=4" class="page-numbers">4</a>
            <a href="shop_list.php?page=5" class="page-numbers">5</a>
            <a href="shop_list.php?page=6" class="page-numbers">6</a>
            <a href="shop_list.php?page=7" class="page-numbers">7</a>
            <a href="shop_list.php?page=8" class="page-numbers">8</a>
            <a href="shop_list.php?page=9" class="page-numbers">9</a>
            <?php if($page == $all_page_number) { ?>
            Next
            <?php } else {  ?>
            <a href="eventItiran.php?page=<?php echo $page +1; ?>" class="page-numbers next">Next</a>
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

</body>

</html>