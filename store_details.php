<?php 
require('dbconnect.php');
session_start();
echo '<br>'; echo '<br>';echo '<br>';
echo $_GET['name'];

$sql = 'SELECT * FROM `kami_shops` WHERE `shop_name`=? ORDER BY `shop_id` DESC LIMIT 1';
$data = array($_GET['name']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$store_detail = $stmt->fetch(PDO::FETCH_ASSOC);


var_dump($store_detail);

 ?>

<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
<link href=“assets/css/bootstrap.css” rel=“stylesheet”>
   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>お店詳細</title>
  <meta name="description" content="">
  <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/321_base.css">
   <link rel="stylesheet" href="css/vendor.css">
   <link rel="stylesheet" href="css/321_main.css">

   <!-- script
   ================================================== -->
  <script src="js/modernizr.js"></script>
  <script src="js/pace.min.js"></script>

   <!-- favicons
  ================================================== -->
  <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon"> -->

</head>

<body id="top">

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
               <li class="has-children"><a href="store_review.html" title="">お店を投稿する</a></li>
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

   <!-- content
   ================================================== -->
   <div id="link1"></div>
   <section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">
      
        <section>
           <br>
           <br>

          
          <div class="primary-content">

            <h1 class="entry-title add-bottom">店名：<?php echo $store_detail['shop_name_abc']; ?></h1>
            <p>ジャンル：<?php echo $store_detail['shop_type']; ?></p>
      <a href="store_review_edit.html" title=""><button type="submit" class="submit button-primary">お店情報を編集する</button></a>


            <br>
            <br>

<div class="moroha">
<!-- <a href="#link1" class="bz"><span class="icon-home-2"></span>店トップ</a> -->
<a href="#link2" class="bz"><span class="icon-report-1"></span>写真</a>
<a href="#link3" class="bz"><span class="icon-photo-1"></span>レビュー</a>
<!-- <a href="https://retty.me/area/PRE27/ARE89/SUB8901/100001269802/menu/">
<span class="icon-menu-1"></span>メニュー・プラン</a> -->

<!-- <div class="dropdown" style="display:inline-block;"> -->
<a href="#link4" class="bz">
<span class="icon-map-1"></span>地図・アクセス</a>
<!-- </div> -->
<!-- <div class="dropdown__child">
<ul class="dropdown__maps">
<li><a href="https://retty.me/area/PRE27/ARE89/SUB8901/100001269802/map/">炭焼Bar 心 梅田店の地図</a></li>
<li><a href="https://retty.me/area/PRE27/ARE89/SUB8901/100001269802/peripheral-map/">近くのお店</a></li>
</ul>
</div> -->
</div>


<br>
<br>
<br>



            <div id="link2">
            <h1>写真</h1>
            </div>


<br>
<br>

<div class="slider">
<div>
<img src="images/thumbs/salad.jpg" alt="" style="padding: 0px 50px;">
</div>
<div>
<img src="images/thumbs/salad.jpg" alt="" style="padding: 0px 50px;">
</div>
<div>
<img src="images/thumbs/salad.jpg" alt="" style="padding: 0px 50px;">
</div>
</div>



            <div id="link3">
            <h1>レビュー</h1>
            </div>

            <div class="comments-wrap">
            <div id="comments" class="row">
                <div class="col-full">
               <!-- <h3>5 Comments</h3> -->
               <!-- commentlist -->
               <ol class="commentlist">
                  <li class="depth-1">
                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-01.jpg" alt="">
                     </div>
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite>Itachi Uchiha</cite>
                            <div class="comment-meta">
                               <time class="comment-time" datetime="2014-07-12T23:05">Jul 12, 2014 @ 23:05</time>
                               <span class="sep">/</span><a class="reply" href="#">Reply</a>
                            </div>
                         </div>
                         <div class="comment-text">
                            <p>Adhuc quaerendum est ne, vis ut harum tantas noluisse, id suas iisque mei. Nec te inani ponderum vulputate,
                            facilisi expetenda has et.</p>

<table cellpadding="0" cellspacing="30"><tbody>
<tr>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
</tr>
</tbody></table>

                         </div>
                      </div>
                  </li>
                  <li class="thread-alt depth-1">
                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-04.jpg" alt="">
                     </div>
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite>John Doe</cite>
                            <div class="comment-meta">
                               <time class="comment-time" datetime="2014-07-12T24:05">Jul 12, 2014 @ 24:05</time>
                               <span class="sep">/</span><a class="reply" href="#">Reply</a>
                            </div>
                         </div>
                         <div class="comment-text">
                            <p>Sumo euismod dissentiunt ne sit, ad eos iudico qualisque adversarium, tota falli et mei. Esse euismod
                            urbanitas ut sed, et duo scaevola pericula splendide. Primis veritus contentiones nec ad, nec et
                            tantas semper delicatissimi.</p>

                            <table cellpadding="0" cellspacing="30"><tbody>
<tr>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
</tr>
</tbody></table>

                         </div>
                      </div>
                     <!-- <ul class="children">
                        <li class="depth-2">
                           <div class="avatar">
                              <img width="50" height="50" class="avatar" src="images/avatars/user-03.jpg" alt="">
                           </div> -->
                           <!-- <div class="comment-content">
                               <div class="comment-info">
                                  <cite>Kakashi Hatake</cite>
                                  <div class="comment-meta">
                                     <time class="comment-time" datetime="2014-07-12T25:05">Jul 12, 2014 @ 25:05</time>
                                     <span class="sep">/</span><a class="reply" href="#">Reply</a>
                                  </div>
                               </div>
                               <div class="comment-text">
                                  <p>Duis sed odio sit amet nibh vulputate
                                  cursus a sit amet mauris. Morbi accumsan ipsum velit. Duis sed odio sit amet nibh vulputate
                                  cursus a sit amet mauris</p>
                               </div>
                           </div> -->
                           <!-- <ul class="children">
                              <li class="depth-3">
                                 <div class="avatar">
                                    <img width="50" height="50" class="avatar" src="images/avatars/user-04.jpg" alt="">
                                 </div>
                                 <div class="comment-content">
                                     <div class="comment-info">
                                        <cite>John Doe</cite>
                                        <div class="comment-meta">
                                           <time class="comment-time" datetime="2014-07-12T25:15">July 12, 2014 @ 25:15</time>
                                           <span class="sep">/</span><a class="reply" href="#">Reply</a>
                                        </div>
                                     </div>
                                     <div class="comment-text">
                                        <p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est
                                        etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>
                                     </div>
                                 </div>
                              </li>
                           </ul> -->
                        </li>
                     </ul>
                  </li>
                  <li class="depth-1">
                     <div class="avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-02.jpg" alt="">
                     </div>
                     <div class="comment-content">
                         <div class="comment-info">
                            <cite>Shikamaru Nara</cite>
                            <div class="comment-meta">
                               <time class="comment-time" datetime="2014-07-12T25:15">July 12, 2014 @ 25:15</time>
                               <span class="sep">/</span><a class="reply" href="#">Reply</a>
                            </div>
                         </div>
                         <div class="comment-text">
                            <p> break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!break a leg!</p>

                            <table cellpadding="0" cellspacing="30"><tbody>
<tr>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt="">
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
<td>
<img src="images/thumbs/salad.jpg" width="150" height="150" alt=""/>
</td>
</tr>
</tbody></table>

                         </div>
                     </div>
                  </li>
               </ol> <!-- Commentlist End -->
               <!-- respond -->
               <!-- <div class="respond">
                <h3>Leave a Comment</h3> -->
                  <!-- <form name="contactForm" id="contactForm" method="post" action="">
                       <fieldset>
                     <div class="form-field">
                              <input name="cName" type="text" id="cName" class="full-width" placeholder="Your Name" value="">
                     </div>
                     <div class="form-field">
                              <input name="cEmail" type="text" id="cEmail" class="full-width" placeholder="Your Email" value="">
                     </div>
                     <div class="form-field">
                              <input name="cWebsite" type="text" id="cWebsite" class="full-width" placeholder="Website"  value="">
                     </div>
                     <div class="message form-field">
                        <textarea name="cMessage" id="cMessage" class="full-width" placeholder="Your Message" ></textarea>
                     </div>
                     <button type="submit" class="submit button-primary">Submit</button>
                       </fieldset> -->
                      <!-- </form> --> <!-- Form End -->
               <!-- </div> --> <!-- Respond End -->
            </div> <!-- end col-full -->
         </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->


            <!-- <p class="lead"></p>

            <p>Duis ex ad cupidatat tempor Excepteur cillum cupidatat fugiat nostrud cupidatat dolor sunt sint sit nisi est eu exercitation incididunt adipisicing veniam velit id fugiat enim mollit amet anim veniam dolor dolor irure velit.</p>
            <p>ええ感じの店やったから、また行きたいと思ってんねん！ほんまに、怒るでしかし。</p> -->


            <br>
            <br>

            <div id="link4">
            <h1>地図</h1>
            </div>

            <br>

            <div class="content-media">
             <div id="map-wrap">
              <div id="map-container"></div>
               <div id="map-zoom-in"></div>
                <div id="map-zoom-out"></div>
                 </div>
                  </div>

<br><br><br>

<div align="center">
<a href="#link1">TOP</a>
</div>

        </section>
      

      </div> <!-- end col-twelve -->
    </div> <!-- end row -->   
   </section> <!-- end content -->



   
   <!-- footer
   ================================================== -->

<footer>
                  <div align="center">
                  <p class="keigo"><span>© kami 2018</span>
                  <span>by team pelo</a></span></p>
                  </div>

                <!-- end footer-bottom -->
   </footer>

   <!-- Java Script
   ================================================== -->
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="http://maps.google.com/maps/api/js?v=3.13&amp;sensor=false"></script>
   <script src="js/main.js"></script><link rel="stylesheet" href="slick.css">
   <script src="slick.min.js"></script>


</body>

</html>