<?php
 require('dbconnect.php');
 $sql = 'SELECT * FROM `kami_events`';
    $stmt = $dbh->prepare($sql);
      $stmt->execute();
      while(true) {
      $kami_event = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($kami_event == false) {
         break;
      }
   $kami_events[] = $kami_event;
     }




// $keyword = mb_convert_kana($keyword, 's')
// $ary_keyword = preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
// foreach( $ary_keyword as $val ){
//     // 検索条件を設定するコードをここに書く
// }

   //  $keigo= '%'.$_GET['s'].'%';
   //  $search_sql = 'SELECT * FROM `kami_events` WHERE `event_name` LIKE ? OR `detail` LIKE ?';
   //  $search_data = array($keigo,$keigo);
   //  $search_stmt = $dbh->prepare($search_sql);
   //  $search_stmt->execute($search_data);
   //  while(true) {
   //  $kami_search_event = $search_stmt->fetch(PDO::FETCH_ASSOC);
   //  if ($kami_search_event == false) {
   //       break;
   //    }
   // $kami_search_events[] = $kami_search_event;
   //   } 
   // // var_dump($kami_search_events);


 
  
  //SQL(テーブルから列を抽出する
  $keigo =@$_GET['s'];

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
      $where .= "(event_name LIKE '%$array[$i]%' OR detail LIKE '%$array[$i]%')";
      if ($i <count($array) -1){
        $where .= " AND ";
      }
     }

     // var_dump($search_sql);exit;
    $search_sql = $search_sql . ' ' . $where;
    var_dump($search_sql);exit;

    $search_stmt = $dbh->prepare($search_sql);
    $search_stmt->execute();
    $kami_search_events = array();

    while(true) {
      $kami_search_event = $search_stmt->fetch(PDO::FETCH_ASSOC);
    if ($kami_search_event == false) {
         break;
      }
      $kami_search_events[] = $kami_search_event;
    }

      //  var_dump($kami_search_events);
      // // exit();
  }

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
               <li class="has-children"><a href="home.html" title="">ホーム</a></li>   
               <li class="has-children"><a href="eventNew.html" title="">イベント作成</a></li>                          
               <li class="current">
                  <a href="eventItiran.html" title="">イベント一覧</a>
                  <ul class="sub-menu">
                     <li><a href="category.html">Wordpress</a></li>
                     <li><a href="category.html">HTML</a></li>
                     <li><a href="category.html">Photography</a></li>
                     <li><a href="category.html">UI</a></li>
                     <li><a href="category.html">Mockups</a></li>
                     <li><a href="category.html">Branding</a></li>
                  </ul>
               </li>
               <li class="has-children">
                  <a href="omiseItiran.html" title="">お店</a>
                  <ul class="sub-menu">
                     <li><a href="single-video.html">Video Post</a></li>
                     <li><a href="single-audio.html">Audio Post</a></li>
                     <li><a href="single-gallery.html">Gallery Post</a></li>
                     <li><a href="single-standard.html">Standard Post</a></li>
                  </ul>
               </li>
       <li class="has-children">
                  <a href="Profile.html" title="">マイページ</a>
                  <ul class="sub-menu">
                     <li><a href="single-video.html">Video Post</a></li>
                     <li><a href="single-audio.html">Audio Post</a></li>
                     <li><a href="single-gallery.html">Gallery Post</a></li>
                     <li><a href="single-standard.html">Standard Post</a></li>
                  </ul>
               </li>
               
            </ul>
         </nav> <!-- end main-nav-wrap -->

         <div class="search-wrap">
            
            <form role="search" method="get" class="search-form" action="eventItiran.php">
               <label>
                  <span class="hide-content">Search for:</span>
                             <select class="search-select" name="list">
        <option value="item1" selected>イベントを探す</option>
        <option value="item2">店を探す</option>
       
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
            <h1>イベント一覧：<?php echo $_GET['s']; ?></h1>
         </div>         
      </div>
       </center>
  

    <div class="row masonry">

      <!-- brick-wrapper -->
         <div class="bricks-wrapper">

          <div class="grid-sizer"></div>

<?php if (!empty($_GET)) { ?>
  <?php for ($i=0; $i<count($kami_search_events);$i++){ ?>


         <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-pattern.jpg" alt="Pattern">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>
                
                     <h1 class="entry-title"><a href="single-standard.html"><?php echo $kami_search_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>
                     <?php echo $kami_search_events[$i]["detail"]; ?>

                  </div>
               </div>

            </article> <!-- end article -->
    <?php } ?>
  <?php } else { ?>
  <?php for ($i=0; $i<count($kami_events);$i++){ ?>
         <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-pattern.jpg" alt="Pattern">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>
                
                     <h1 class="entry-title"><a href="single-standard.html"><?php echo $kami_events[$i]["event_name"]; ?></a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>
                     <?php echo $kami_events[$i]["detail"]; ?>

                  </div>
               </div>

            </article> <!-- end article -->
   <?php } ?>
    <?php } ?>

         </div> <!-- end brick-wrapper --> 

    </div> <!-- end row -->

    <div class="row">
      
      <nav class="pagination">
          <span class="page-numbers prev inactive">Prev</span>
        <span class="page-numbers current">1</span>
        <a href="#" class="page-numbers">2</a>
          <a href="#" class="page-numbers">3</a>
          <a href="#" class="page-numbers">4</a>
          <a href="#" class="page-numbers">5</a>
          <a href="#" class="page-numbers">6</a>
          <a href="#" class="page-numbers">7</a>
          <a href="#" class="page-numbers">8</a>
          <a href="#" class="page-numbers">9</a>
        <a href="#" class="page-numbers next">Next</a>
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

</body>

</html>