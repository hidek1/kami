<?php 
require('dbconnect.php');
$sql = 'SELECT * FROM `kami_members` WHERE `member_id`=?';
  $data = array($_GET['member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  // データ一件取得 (レコードを取得)
  $profile = $stmt->fetch(PDO::FETCH_ASSOC);



  $sql = 'SELECT * FROM `event_joining` LEFT JOIN `kami_events` ON `event_joining`.`event_id`=`kami_events`.`event_id` WHERE `member_id`=?';
  $data = array($_GET['member_id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

   while(true) {
      $event_joining = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($event_joining == false) {
         break;
      }
      $event_joinings[] = $event_joining;
    }


  $sql = 'SELECT * FROM `kami_reviews` LEFT JOIN `kami_shops` ON `kami_reviews`.`shop_id`=`kami_shops`.`shop_id` WHERE `member_id`=?';
  $data = array($_GET['member_id']);
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
  <title>Category Page - Abstract</title>
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

<body id="top">
 <!-- header 
   ================================================== -->
   <header class="short-header">   

      <div class="gradient-block"></div>  

      <div class="row header-content">

         <div class="logo">
            <a href="home.html">Author</a>
         </div>

         <nav id="main-nav-wrap">
            <ul class="main-navigation sf-menu">
               <li class="has-children"><a href="home.html" title="">ホーム</a></li>   
               <li class="has-children"><a href="eventNew.html" title="">イベント作成</a></li>                          
               <li class="has-children">
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
       <li class="current">
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
            
            <form role="search" method="get" class="search-form" action="#">
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
   

  <section id="page-header">
      <center>
            <h1>Profile</h1>
      </center>

   </section>




                       

                            
                   <center>
                            <h1><?php echo $profile['nickname']; ?></h1>
            </center>
         

  <center>
                           <img src="picture_path/<?php echo $profile['picture_path']; ?>" width="200" height="200" alt="building">
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
                     <a href="ProfileEdit.html" title=""><button type="submit" class="submit button-primary">Profile Edit</button></a>
                     </center>

                         </fieldset>
                      
                          

   



   <!-- page header
   ================================================== -->
   
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
<?php for ($i=0; $i<count($event_joinings);$i++){ ?>
<div class="col-xs-4 col-md-4 col-lg-4">
          <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                    <img src="images/thumbs/moet.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                <div class="entry-header">

                  <div class="entry-meta">
                    <span class="cat-links">
                    </span>     
                  </div>

                  <h1 class="entry-title"><a href="single-standard.html"><?php echo $event_joinings[$i]['event_name']; ?></a></h1>
                  
                </div>
            <div class="entry-excerpt">
              <?php echo $event_joinings[$i]['detail']; ?>
            </div>
               </div>

            </article> <!-- end article -->
          </div>
<?php } ?>




          </div>
           </div>
          




<!-- page header
   ================================================== -->
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
  <?php for ($i=0; $i<count($reviews);$i++){ ?>

<div class="col-xs-4 col-md-4 col-lg-4">

          <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                    <img src="images/thumbs/dinner.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                <div class="entry-header">

                  <div class="entry-meta">
                    <span class="cat-links">
                    </span>     
                  </div>

                  <h1 class="entry-title"><a href="single-standard.html"><?php echo $review['shop_name_abc']; ?>(<?php echo $reviews[$i]['shop_name_abc']; ?>)</a></h1>
                  
                </div>
            <div class="entry-excerpt">
             <?php echo $reviews[$i]['review']; ?>
            </div>
               </div>

            </article> <!-- end article -->
</div>
    <?php } ?>


  </div>
   </div>


    <center>
    <footer>
                  <p class="keigo"><span>© kami 2018</span> 
                  <span>by team pelo</a></span></p>              
             
                <!-- end footer-bottom -->  
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

</body>

</html>