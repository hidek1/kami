<?php 
//getで持ってくる？
//selectで表示

 ?>
 

<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
	<meta charset="utf-8">
	<title>イベントの作成</title>
	<meta name="description" content="">  
	<meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

 	<!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/base.css">
   <link rel="stylesheet" href="css/vendor.css">  
   <link rel="stylesheet" href="css/pooh_main.css">
   <link rel="stylesheet" href="css/pooh_bootstrap.css">
        

   <!-- script
   ================================================== -->
	<script src="js/modernizr.js"></script>
	<script src="js/pace.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js/slick-1.8.0/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="js/slick-1.8.0/slick/slick-theme.css"/>

   <!-- favicons
	================================================== -->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body id="top">
<div>



   <!-- header 
   ================================================== -->
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
<!-- <div id="content-wrap" class="styles"> -->
<!-- created time & edit button [right top] -->
<div class ="container" style="padding-top: 200px;">
		<div class="row">
			<div class="col-lg-9" >
				<div class="row">
			<div class="col-lg-4" >
				<h2>DATE '$date' '$time' ~ </h2>
			</div>
			<div class="col-lg-8" >
				<h2>@ '$to_whom' MIN '$min_count' MAX'$max_count'</h2>
			</div>
		</div>
		</div>
			<div class="col-lg-3" >
				<p style=" vertical-align: middle;">CREATED AT '$created_at'</p>
				<form action="GET">
					<input style="border-radius: 5px;" type="button" value="イベントの編集">
				</form>
			
			</div>
			</div>
			</div>
		
	<div class ="container">
		
			<div class="col-lg-3" >
				
			</div>
		</div>
</div>
	</div>

<!-- main info about the event [top-block]-->
	<div class ="container" style="padding-top: 30px;">
		<div class="row">
<!-- image of the shop or event [top-block left]-->
			<div class="col-lg-3" style="text-align:center;">
				<img src="img/images.jpg" style="  border-radius: 15px;" width="150" height="150">
			</div>
			<div class="col-lg-9" >
				<h1>$event_name</h1>
			
			<div class="row">
				<div class="col-lg-6" >
				<h2>Meeting[meeting_place]</h2>
			</div>
			<div class="col-lg-6" >
				<h2>DeadLine $dead/line</h2>
			</div>
</div>
			</div>
		</div>
	</div>



	<div class ="container">
		<div class="row">
			<div class="col-lg-2" >
				<h2>NAME</h2>
			</div>
			<div class="col-lg-5" >
				<h2>$店の名前</h2>
			</div>
			<div class="col-lg-5" hidden-md-down>
			</div>
		</div>
	</div>


	<div class ="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-lg-2" >
				<h2>NOTE</h2>
			</div>
			<div class="col-lg-10" >
				<p class="lead">ランプちょっとこするだけだよ〜！イエス、サー、ご主人様 ご用はなあに？ハイ、ご注文をどうぞ.お気に召すまま！夜ごとレストランで豪華なメニュー！ カモン、ご注文はなんなりどうぞ、あなたのしもべ イエス、サー！極上 最高 サービス よう！ザ・ボス！大将！キング！お望みのものをお手元に、ドゥビドゥバッバー！豪華絢爛、天まで届け〜最高の友達 たとえどんなときでも</p>
			</div>
		</div>
	</div>




<div class ="container" style="padding-top: 30px;" >
	<div class="row">
		<div class="col-lg-12" >
			<h2>INFO</h2>
			<div class= "slider-for">
				<div class ="slider-nav">
					<div><a href="#"><img src="img/images.jpg" ></a></div>
					<div><a href="#"><img src="img/download-1.jpg"></a></div>
					<div><a href="#"><img src="img/download-3.jpg"></a></div>
					<div><a href="#"><img src="img/download-5.jpg"></a></div>
				</div>
			</div>
		</div>
	</div>
</div>






	<div class ="container" style="padding-top: 30px;" >
		<div class="row">
			<div class="col-lg-6" >
				<h3>Attending</h3>	
				<div style="background-color: #f5f5f5; border-radius: 20px; padding: 10px;">
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
				</div>
			</div>
			
			<div class="col-lg-6" >
				<h3>Interested</h3>
				<div style="background-color: #f5f5f5; border-radius: 20px; padding: 10px;">
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
				</div>
		</div>
	</div>

	<div class ="container full-width">
		<div class="row  background-color: #f5f5f5;">
			<form action="POST">
		
				<div class="col-lg-6" style="text-align: center;padding:50px; border-radius: 15px;">
					<a style="border-radius: 5px;" class="button button-primary full-width" href="eventView.html=?action=attend&id=<?php echo $SESSION['id']">参加する</a>
					<!-- 	<a class="button button-primary full-width" href="eventView.html=?action=attend&id=<?php echo $SESSION['id']">参加を取りやめる</a> -->
						</div>
			
				<div class="col-lg-6" style="text-align: center; padding:50px; border-radius: 30px;">
					<a style="border-radius: 5px;" class="button button-primary full-width" href="eventView.html=?action=interested&id=<?php echo $SESSION['id']">興味がある</a>
					<!-- <a class="button button-primary full-width" href="eventView.html=?action=interested&id=<?php echo $SESSION['id']">興味がない</a> -->
				</div>
			</form>
		</div>
</div>

   </div> <!-- end styles -->


   


   
   <!-- footer
   ================================================== -->
 

   	 <footer>
<center>
<p class="keigo"><span>© kami 2018</span> 
<span>by team pelo</a></span></p>
</center>
  <!-- end footer-bottom -->  
   </footer>  

   </footer>  

   <div id="preloader"> 
    	<div id="loader"></div>
   </div> 

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script>
   <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="js/slick-1.8.0/slick/slick.min.js"></script>


<script type="text/javascript">
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: true,
  centerMode: true,
  focusOnSelect: true
});
</script>


</body>

</html>