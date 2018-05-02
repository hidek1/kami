 <!-- header 
   ================================================== -->
   
   <link rel="stylesheet" href="css/modal.css">  
   <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<header class="short-header"">   

    <div class="gradient-block"></div>  

  <div class="row header-content">

         <div class="logo">
            <a href="home.php" style="background-size: 80px 90px; height: 110px;">Author</a>
         </div>

         <nav id="main-nav-wrap">
            <ul class="main-navigation sf-menu">
              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/home.php"): ?>
              <li class="current"><a href="home.php" title="">ホーム</a></li>
              <?php else: ?>
               <li class="has-children"><a href="home.php" title="">ホーム</a></li>
              <?php endif ?>

              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/eventNew.php"): ?>
               <li class="current"><a href="eventNew.php" title="">イベント作成</a></li>
              <?php else: ?>
               <li class="has-children"><a href="eventNew.php" title="">イベント作成</a></li>
              <?php endif ?>

              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/store_review.php"): ?>
               <li class="current"><a href="store_review.php" title="">お店を投稿する</a></li> 
              <?php else: ?>
               <li class="has-children"><a href="store_review.php" title="">お店を投稿する</a></li> 
              <?php endif ?>

              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/eventItiran.php"): ?>
               <li class="current"><a href="eventItiran.php" title="">イベント一覧</a></li>
              <?php else: ?>
               <li class="has-children"><a href="eventItiran.php" title="">イベント一覧</a></li>
              <?php endif ?>

              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/shop_list.php"): ?>
               <li class="current"><a href="shop_list.php" title="">お店一覧</a></li>
              <?php else: ?>
               <li class="has-children"><a href="shop_list.php" title="">お店一覧</a></li>
              <?php endif ?>

              <?php if ($_SERVER['SCRIPT_NAME'] =="/kami/Profile.php"): ?>
               <li class="current"><a href="Profile.php" title="">マイページ</a></li>
              <?php else: ?>
               <li class="has-children"><a href="Profile.php" title="">マイページ</a></li>
              <?php endif ?>


               <li class="has-children">
                  <a href="logout.php" title="">ログアウト</a>
               </li>
               
            </ul>
         </nav> <!-- end main-nav-wrap -->

         <div class="search-wrap tenkyu">
            
            <form role="search" method="get" class="search-form" action="search.php">
               <label>
                  <span class="hide-content">Search for:</span>
                             <select class="search-select" name="list">
        <option value="event" selected>イベントを探す</option>
        <option value="omise">店を探す</option>
       
      </select>
                  <input type="search" class="search-field" placeholder="Type Your Keywords" value="" name="s" title="Search for:" autocomplete="off"  style="font-size: 60px">

               </label>
               <input type="submit" class="search-submit" value="Search">

            </form>


            <a href="#" id="close-search" class="close-btn">Close</a>

         </div> <!-- end search wrap -->  



<div id="modal-content" style="text-align: center;">
  <div style="overflow: auto; height: 500px;">
    <?php if (isset($tsuuti_events)) { ?>
    　<?php for ($i=count($tsuuti_events)-1; $i>=0;$i--){ ?>
    　　<?php if (strtotime(date('Y-m-d H:i')) > strtotime($tsuuti_events[$i]["answer_limitation"])){ ?>
       <?php if ($tsuuti_events[$i]['min']<=$tsuuti_events[$i]['join_count']){ ?>
       <p style=" margin-bottom: 3rem;">イベント <a href="eventView.php?id=<?php echo $tsuuti_events[$i]["event_id"]; ?>"><?php  
       echo $tsuuti_events[$i]["event_name"] ?></a>が成立しました。</p>
       <hr>
       <?php } else {  ?>
       <p style=" margin-bottom: 3rem;">イベント <a href="eventView.php?id=<?php echo $tsuuti_events[$i]["event_id"]; ?>"><?php  
       echo $tsuuti_events[$i]["event_name"] ?></a>は不成立でした。</p>
       <hr>
    　　　<?php } ?>
    　　<?php } ?>
    　<?php } ?>
    <?php } else { ?>
    通知がありません
    <?php } ?>
  </div>
  <p><a id="modal-close" class="button-link">閉じる</a></p>
</div>


         <div class="triggers">
            <a id="modal-open" class="button-link" href="#"><i class="fas fa-bell" style="font-size: 25px; color: #FFFF00;"></i></a>
            <a class="search-trigger" href="#"><i class="fa fa-search" style="font-size: 25px;"></i></a>
            <a class="menu-toggle" href="#"><span>Menu</span></a>
         </div> <!-- end triggers -->  
         
　</div>   

      
</header> <!-- end header -->
