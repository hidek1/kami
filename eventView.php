<?php
//今後
	//写真の表示
	//興味ユーザーの作成
	$dsn ='mysql:dbname=kami;host=localhost';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->query('SET NAMES utf8');
	$_SESSION['id'] = 18;
	$_GET['id'] = 13;


	$event_sql='SELECT * FROM `kami_events` WHERE `event_id` = ? ';
	$event_data= array($_GET['id']);
	$stmt = $dbh->prepare($event_sql);
	$stmt->execute($event_data);
	$event =$stmt -> fetch(PDO::FETCH_ASSOC);



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
			<div class="col-xs-0 col-md-0 col-lg-6" >
			</div>
			<div class="col-xs-12 col-md-12 col-lg-6" >
				<p style=" text-align:right; vertical-align: middle;">作成日時[
					<?php 
					$created = $event['created'];
					$created = date("m-d H:i", strtotime($created));
					echo $created ;?>]
				</p>
				<p style=" text-align:right; vertical-align: middle;">編集日時[
					<?php 
					$modified = $event['modified'];
					$modified = date("m-d H:i", strtotime($modified));
					echo $modified ;?>]
				</p>
			</div>
	</div>
</div>
<div class ="container">
	<div class="row" style="height: 12rem;">
		<div class="col-xs-3 col-md-3 col-lg-3" >
			<h2>DATE <br><?php
				$starttime = $event['starttime'];
				$starttime = date("m-d H:i", strtotime($starttime));
				echo $starttime ;?>~</h2>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h2>
				<?php if ($event['min'] != '') { ;?>MIN <?php echo $event['min'];} ?>
				<?php if ($event['max'] != '') { ;?>MIN <?php echo $event['max'];} ?>
				<br>@<?php echo $event['invite'] ;?>
			</h2>
		</div>
		<div class="col-xs-3 col-md-3 col-lg-3" style=" top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<a  href="eventEdit.php?id=<?php echo $event['event_id'];?>" ><button  style="border-radius: 5px;">編集する</button></a>
		</div>
	</div>
</div>

<!-- main info about the event [top-block]-->
<div class ="container" style="padding-top: 50px;">
	<div class="row">
<!-- image of the shop or event [top-block left]-->
		<div class="col-xs-3 col-md-3 col-lg-3" style="text-align:center;">
			<img src="img/images.jpg" style="  border-radius: 15px;">
		</div>
			<div class="col-xs-9 col-md-9 col-lg-9" >
				<h1><?php echo $event['event_name'] ;?></h1>
			<div class="row">
				<div class="col-xs-6 col-md-6 col-lg-6" >
				<h2>MEET AT <br><?php 
					$meeting_time = $event['meeting_time'];
					$meeting_time = date("m-d H:i", strtotime($meeting_time));
					echo $meeting_time ;?> @<?php echo $event['meeting_place'] ;?></h2>
			</div>
			<div class="col-xs-6 col-md-6 col-lg-6" >
				<h2>DeadLine <br>
					<?php 
					$limit = $event['answer_limitation'];
					$limit = date("m-d H:i", strtotime($limit));
					echo $limit ;?></h2>
			</div>
		</div>
			</div>
		</div>
	</div>



	<div class ="container">
	<?php if($event['graduation'] != 0 || $event['teachers'] != 0 || $event['set_price'] != '指定なし'){ ?>
		<div class="row">
			<div class="col-xs-2 col-md-2 col-lg-2" >
				<h2 >TAG</h2>
			</div>
			<div class="col-xs-10 col-md-10 col-lg-10">
				<h2>
					<p>
					<?php if ($event['graduation'] == 1) {?>
					グラパ 
					<?php if ( $event['teachers'] == 1 || $event['set_price'] != '指定なし') {?>
					 /
					<?php } }?>
					<?php if ($event['teachers'] == 1) {?>
					先生も参加する
					<?php if ($event['teachers'] == 1 && $event['set_price'] != '指定なし') {?>
					/
					<?php }}?>
					<?php if ($event['set_price'] != '指定なし') {?>
					<?php echo $event['set_price'] ?> 
					<?php } ?>
					</p>
				</h2>	
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col-xs-2 col-md-2 col-lg-2" >
				<h2>WHERE</h2>
			</div>
			<div class="col-xs-5 col-md-5 col-lg-5" >
				<h2><?php echo $event['event_place'] ;?></h2>
			</div>
			<div class="col-xs-5 col-md-5 col-lg-5" hidden-md-down>
			</div>
		</div>
	</div>


	<div class ="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-xs-2 col-md-2 col-lg-2" >
				<h2>NOTE</h2>
			</div>
			<div class="col-xs-10 col-md-10 col-lg-10" >
				<p class="lead"><?php echo $event['detail'] ;?></p>
			</div>
		</div>
	</div>




<div class ="container" style="padding-top: 30px;" >
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12" >
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
			<div class="col-xs-6 col-md-6 col-lg-6" >
				<h3>Attending</h3>	
				<div style="background-color: #f5f5f5; border-radius: 20px; padding: 10px;">
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
					$user_pic $user_nickname <br>
				</div>
			</div>
			
			<div class="col-xs-6 col-md-6 col-lg-6" >
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
	</div>

	<div class ="container full-width">
		<div class="row  background-color: #f5f5f5;">
		
				<div class="col-xs-6 col-md-6 col-lg-6" style="text-align: center;padding:50px; border-radius: 15px;">
					<a style="border-radius: 5px;" class="button button-primary full-width" href="eventView.html=?action=attend&id=<?php echo $SESSION['id'] ?>"> 参加する</a>
					<!--<a class="button button-primary full-width" href="eventView.html=?action=attend&id=<?php echo $SESSION['id']?>">参加を取りやめる</a>-->
						</div>
			
				<div class="col-xs-6 col-md-6 col-lg-6" style="text-align: center; padding:50px; border-radius: 30px;">
					<a style="border-radius: 5px;" class="button button-primary full-width" href="eventView.html=?action=interested&id=<?php echo $SESSION['id']?>">興味がある</a>
					<!-- <a class="button button-primary full-width" href="eventView.html=?action=interested&id=<?php echo $SESSION['id'] ?>">興味がない</a> -->
				</div>

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