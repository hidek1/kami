<?php  ?>
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
               <li class="current"><a href="home.html" title="">ホーム</a></li>   
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
         <div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.html">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this"  style="background-color: #F5A9A9;">

               <div class="entry-thumb">
                  <a href="single-standard.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html">グラパ！</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="store_details.html">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>
                     ホゲ保ゲホゲホgへオエh後ほえほえgへおhゲオhゲオへごhゲオhごえgほえgほえgホゲホゲほえgホゲ保ゲホゲホgへお保gほえ午後gへおえほえgほげほげほえgほえgほげh...<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>
<div class="col-xs-4">
            <!-- <div class ="container"> -->
         <!--       <div class="row">
         <div class="col-xs-10 col-md-10 col-lg-10"> -->
            <article class="brick entry format-standard animate-this">

               <div class="entry-thumb">
                  <a href="eventView.html.html" class="thumb-link">
                     <img src="images/thumbs/diagonal-building.jpg" alt="building">             
                  </a>
               </div>

               <div class="entry-text">
                  <div class="entry-header">

                     <div class="entry-meta">
                        <span class="cat-links">
                            あと何日
                                                     
                        </span>        
                     </div>

                     <h1 class="entry-title"><a href="eventView.html.html">イベント名</a></h1>
                     
                  </div>
                  <div class="entry-excerpt">
                     開催場所: <a href="#">店名</a><br>
                     開催日: ○月○日<br>
                     開始時間　何時何分<br>
                     参加予定人数 3人/12人<br>
                     詳細<br>

                  </div>
               </div>

            </article> <!-- end article -->
</div>

         
    <!-- </div> end colサイズ指定  -->
   </div>
</div>
             <div class="col-xs-3 col-md-3 col-lg-3 review" >

<ol class="commentlist">
            <h1 class="sintyaku">新着レビュー</h1>


                  <li class="depth-1">

                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-01.jpg" alt="">
                     </div>

                     <div class="comment-content">

                        <div class="comment-info">
                           <cite><a href="store_details.html">店名</a></cite>

                           <div class="comment-meta">
                              <time class="comment-time" datetime="2014-07-12T23:05">Jul 12, 2014 @ 23:05</time>
                            
                           </div>
                        </div>

                        <div class="comment-text">
                           <p>レビューsAdhuc quaerendum est ne, vis ut harum tantas noluisse, id suas iisque mei. Nec te inani ponderum vulputate,
                           facilisi expetenda has et. Iudico dictas scriptorem an vim, ei alia mentitum est, ne has voluptua praesent.</p>
                        </div>

                     </div>

                  </li>

                  <li class="thread-alt depth-1">

                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-04.jpg" alt="">
                     </div>

                     <div class="comment-content">

                        <div class="comment-info">
                           <cite><a href="store_details.html">店名</a></cite>

                           <div class="comment-meta">
                              <time class="comment-time" datetime="2014-07-12T24:05">Jul 12, 2014 @ 24:05</time>
                            
                           </div>
                        </div>

                        <div class="comment-text">
                           <p>Sumo euismod dissentiunt ne sit, ad eos iudico qualisque adversarium, tota falli et mei. Esse euismod
                           urbanitas ut sed, et duo scaevola pericula splendide. Primis veritus contentiones nec ad, nec et
                           tantas semper delicatissimi.</p>                        
                        </div>

                     </div>

                     <ul class="children">

                        <li class="depth-2">

                           <div class="avatar">
                              <img width="50" height="50" class="avatar" src="images/avatars/user-03.jpg" alt="">
                           </div>

                           <div class="comment-content">

                              <div class="comment-info">
                                 <cite><a href="store_details.html">店名</a></cite>

                                 <div class="comment-meta">
                                    <time class="comment-time" datetime="2014-07-12T25:05">Jul 12, 2014 @ 25:05</time>
                                  
                                 </div>
                              </div>

                              <div class="comment-text">
                                 <p>Duis sed odio sit amet nibh vulputate
                                 cursus a sit amet mauris. Morbi accumsan ipsum velit. Duis sed odio sit amet nibh vulputate
                                 cursus a sit amet mauris</p>
                              </div>

                           </div>

                           <ul class="children">

                              <li class="depth-3">

                                 <div class="avatar">
                                    <img width="50" height="50" class="avatar" src="images/avatars/user-04.jpg" alt="">
                                 </div>

                                 <div class="comment-content">

                                    <div class="comment-info">
                                       <cite><a href="store_details.html">店名</a></cite>

                                       <div class="comment-meta">
                                          <time class="comment-time" datetime="2014-07-12T25:15">July 12, 2014 @ 25:15</time>
                                        
                                       </div>
                                    </div>

                                    <div class="comment-text">
                                       <p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est
                                       etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>
                                    </div>

                                 </div>

                              </li>

                           </ul>

                        </li>

                     </ul>

                  </li>

                  <li class="depth-1">

                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-02.jpg" alt="">
                     </div>

                     <div class="comment-content">

                        <div class="comment-info">
                           <cite><a href="store_details.html">店名</a></cite>

                           <div class="comment-meta">
                              <time class="comment-time" datetime="2014-07-12T25:15">July 12, 2014 @ 25:15</time>
                            
                           </div>
                        </div>

                        <div class="comment-text">
                           <p>Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem.</p>
                        </div>

                     </div>

                  </li>
   
               </ol>
            </div>
         </div> <!-- end brick-wrapper --> 
      </div><!-- end row -->
   </div><!-- end container -->

    <!-- <div class="row"> -->
         
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