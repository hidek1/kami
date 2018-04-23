 <!-- header 
   ================================================== -->
   
   <link rel="stylesheet" href="css/modal.css">  
   <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<header class="short-header">   

    <div class="gradient-block"></div>  

  <div class="row header-content">

         <div class="logo">
            <a href="home.php">Author</a>
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

         <div class="search-wrap tenkyu">
            
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



<div id="modal-content">
　<?php for ($i=0; $i<count($tsuuti_events);$i++){ ?>
　　<?php if (strtotime(date('Y-m-d H:i')) > strtotime($tsuuti_events[$i]["answer_limitation"])){ ?>
   <?php if ($tsuuti_events[$i]['min']<$tsuuti_events[$i]['join_count']){ ?>
   <p>イベント <a href="eventView.php?id=<?php echo $tsuuti_events[$i]["event_id"]; ?>"><?php  
   echo $tsuuti_events[$i]["event_name"] ?></a>が成立しました。</p>
   <?php } else {  ?>
   <p>イベント <a href="eventView.php?id=<?php echo $tsuuti_events[$i]["event_id"]; ?>"><?php  
   echo $tsuuti_events[$i]["event_name"] ?></a>は不成立でした。</p>
　　　<?php } ?>
　　<?php } ?>
　<?php } ?>

  <p><a id="modal-close" class="button-link">閉じる</a></p>
</div>


         <div class="triggers">
            <a id="modal-open" class="button-link" href="#"><i class="fas fa-bell" style="font-size: 2.2rem; color: #FFFF00;"></i></a>
            <a class="search-trigger" href="#"><i class="fa fa-search" style="font-size: 2.2rem;"></i></a>
            <a class="menu-toggle" href="#"><span>Menu</span></a>
         </div> <!-- end triggers -->  
         
　</div>   

      
</header> <!-- end header -->
