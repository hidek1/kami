<?php
//今後
	//写真の表示
	//興味ユーザーの作成
	require('dbconnect.php');
	session_start();

//詳細を見るイベントの表示


//ホームや一覧からの表示
	$event_sql='SELECT * FROM `kami_events` WHERE `event_id` = ? ';
	$event_data= array($_GET['id']);
	$stmt = $dbh->prepare($event_sql);
	$stmt->execute($event_data);
	$event =$stmt -> fetch(PDO::FETCH_ASSOC);

//イベントの参加者+自分の参加/状況取得

	$attends = array();
	$interests = array();
	$my_attend = array();
	$attend_sql = 'SELECT * FROM `kami_event_joinings` LEFT JOIN `kami_members` ON `kami_event_joinings`.`member_id`=`kami_members`.`member_id` WHERE `event_id`=?';
	$attend_data = array($_GET['id']);
	$attend_stmt = $dbh->prepare($attend_sql);
	$attend_stmt->execute($attend_data);
// ある件数分ループ
	while(true) {
		$attend = $attend_stmt->fetch(PDO::FETCH_ASSOC);
		if ($attend == false) { break; }

		if ($attend['status'] == 0) {
			$interests[] = $attend;
			$all_interests = count($interests);
			if ($attend['member_id'] == $_SESSION['id']){
			$my_position = $attend;
			$all_interests = count($interests) ;
			}
		}

		if ($attend['status'] == 1) {
			$attends[] = $attend;
			$all_attends = count($attends);
			if ($attend['member_id'] == $_SESSION['id']){
			$my_position = $attend;
			$all_attends = count($attends) ;
			}
		}

	}




	if (!empty($_POST)) {

//[$POST時]kami_event_joiningsに自分がいない時
		if ($_POST['status'] == 1) {
			$update_1_sql = 'INSERT INTO `kami_event_joinings` SET `member_id`=? , `event_id`=? ,`status` = 1 , `created` = NOW() , `modified` = NOW()';
			$update_1_data = array($_SESSION['id'],$_GET['id'],);
			$stmt = $dbh->prepare($update_1_sql);
			$stmt->execute($update_1_data); 
			header('Location: eventView.php?id=' . $_GET['id'] );
			exit();
		}
//[$POST時]kami_event_joiningsに自分がいるがステータスが0の時
	if ($_POST['status'] == 4) {
		$update_1_sql = 'UPDATE `kami_event_joinings` SET `status` = 1 , `modified` = NOW() WHERE `event_id`=? AND `member_id`=? ' ;
		$update_1_data = array($_GET['id'],$_SESSION['id']);
		$stmt = $dbh->prepare($update_1_sql);
		$stmt->execute($update_1_data); 
		header('Location: eventView.php?id=' . $_GET['id'] );
		exit();
		}

//[$POST時]kami_event_joiningsに自分がいない時
	if ($_POST['status'] == 2) {
		$update_1_sql = 'INSERT INTO `kami_event_joinings` SET `member_id`=? , `event_id`=? ,`status` = 0 , `created` = NOW() , `modified` = NOW()';
		$update_1_data = array($_SESSION['id'],$_GET['id'],);
		$stmt = $dbh->prepare($update_1_sql);
		$stmt->execute($update_1_data); 
		header('Location: eventView.php?id=' . $_GET['id'] );
		exit();
		}

//[$POST時]kami_event_joiningsに自分がいるがステータスが1の時
	if ($_POST['status'] == 5 ) {
		$update_0_sql = 'UPDATE `kami_event_joinings` SET `status` = 0 , `modified` = NOW() WHERE `event_id`=? AND `member_id`=? ';
		$update_0_data = array($_GET['id'],$_SESSION['id']);
		$stmt = $dbh->prepare($update_0_sql);
		$stmt->execute($update_0_data); 
		header('Location: eventView.php?id=' . $_GET['id'] );
		exit();
		}

//[$POST時]kami_event_joiningsに自分がいる(ステータスが1or2の時)が、削除したい時
	if ($_POST['status'] == 3 ){
		$sql ='DELETE FROM `kami_event_joinings`  WHERE `event_id`=? AND `member_id`=? ';
		$data = array($_GET['id'],$_SESSION['id']);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);
		header('Location: eventView.php?id='. $_GET['id'] );
		exit();
		}

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

   <!-- content
   ================================================== -->
<!-- <div id="content-wrap" class="styles"> -->
<!-- created time & edit button [right top] -->
<div class ="container" style="padding-top: 200px;">
	<div class="row">
		<div class="col-xs-3 col-md-3 col-lg-3" >
			<h2>DATE <br><?php
				$starttime = $event['starttime'];
				$starttime = date("m-d H:i", strtotime($starttime));
				echo $starttime ;?>~</h2>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h2>
				MIN <?php echo $event['min']; ?>
				MIN <?php echo $event['max']; ?>
				<br>@<?php echo $event['invite'] ;?>
			</h2>
		</div>
		<div class="col-xs-3 col-md-3 col-lg-3" style=" height: 96px;">
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
			<?php if ($event['creater_id'] == $_SESSION['id']): ?>
			<a style=" vertical-align:middle; text-align:right; margin: auto; width: 98px; height: 54px;" href="eventEdit.php?id=<?php echo $event['event_id'];?>" ><button style=" text-align:center; display: block; margin: auto; margin-right: 0px; ;border-radius: 10px;">編集する</button></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- main info about the event [top-block]-->
<div class ="container" style="padding-top: 50px;">
	<div class="row">
<!-- image of the shop or event [top-block left]-->
		<div class="col-xs-3 col-md-3 col-lg-3" style="text-align:center;">
			<img src="event_picture/<?php echo $event['event_picture'] ?>" width="200" height="200" style="  border-radius: 15px; ">
		</div>
		<div class="col-xs-9 col-md-9 col-lg-9" >
		<h1><?php echo $event['event_name'] ;?></h1>
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h2>MEET AT <br><?php 
			$meeting_time = $event['meeting_time'];
			$meeting_time = date(" H:i", strtotime($meeting_time));
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
	<div class="row" style="padding-top: 15px;" >
		<div class="col-xs-2 col-md-2 col-lg-2" >
			<h2 style="margin-top: 0;">WHERE</h2>
		</div>
		<div class="col-xs-5 col-md-5 col-lg-5" >
			<h2 style="margin-top: 0;"><?php echo $event['event_place'] ;?></h2>
		</div>
		<div class="col-xs-5 col-md-5 col-lg-5" hidden-md-down>
		</div>
	</div>
</div>


<div class ="container" style="padding-top: 15px;">
	<div class="row">
		<div class="col-xs-2 col-md-2 col-lg-2" >
			<h2 style="margin-top: 0;">NOTE</h2>
		</div>
		<div class="col-xs-10 col-md-10 col-lg-10" >
			<p class="lead"><?php echo $event['detail'] ;?></p>
		</div>
	</div>
</div>




<div class ="container" style="padding-top: 30px;" >
	<div class="row" style="padding-bottom: 30px;">
		<div class="col-xs-2 col-md-2 col-lg-2" >
			<h2 style="margin-top: 0;">INFO</h2>
		</div>
		<div class="col-xs-10 col-md-12col-lg-10">
		<div class="slider-for">
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/images.jpg" width="300px" height="300px">
				</a>
			</div>
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/download-1.jpg" width="300px" height="300px">
				</a>
			</div>
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/download-1.jpg" width="300px" height="300px">
				</a>
			</div>
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/download-3.jpg" width="300px" height="300px">
				</a>
			</div>
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/download-3.jpg" width="300px" height="300px">
				</a>
			</div>
			<div>
				<a href="#" style="margin:auto; width: 300px; height: 300px; display:block;">
					<img src="img/download-5.jpg" width="300px" height="300px">
				</a>
			</div>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="slider-nav col-xs-12 col-md-12 col-lg-12">
			<div><img src="img/images.jpg" width="200" height="200"></div>
			<div><img src="img/download-1.jpg" width="200" height="200"></div>
			<div><img src="img/download-1.jpg" width="200" height="200"></div>
			<div><img src="img/download-3.jpg" width="200" height="200"></div>
			<div><img src="img/download-3.jpg" width="200" height="200"></div>
			<div><img src="img/download-5.jpg" width="200" height="200"></div>
		</div>
	</div>
</div>

<div class ="container" style="padding-top: 20px;" >
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h3>Attending(<?php echo count($attends);?>)</h3>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<div style="background-color: #f5f5f5; border-radius: 15px; padding: 10px;">
					<?php $no = 0; ?>
					<?php for($i = 0 ; $i < count($attends); $i++ ) { $no++;?>
					<p style="margin:0px; padding:0px 5px; display: inline-block;" ><span style="color: #2E9AFE;">#</span><?php echo $no ; ?>.&thinsp;<?php echo $attends[$i]['nickname'];?></p>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h3>Interested(<?php echo count($interests);?>)</h3>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12" >
					<div style="background-color: #f5f5f5; border-radius: 15px; padding: 10px;">
					<?php $no = 0; ?>
					<?php for($i = 0 ; $i < count($interests); $i++ ) { $no++;?>
					<p style="margin:0px; padding:0px 5px; display: inline-block;" ><span style="color: #2E9AFE;">#</span><?php echo $no ; ?>.&thinsp;<?php echo $interests[$i]['nickname'];?></p>
					<?php } ?>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class ="container full-width" style="padding-top: 20px;" >
<form method="POST">
	<div class="row  background-color: #f5f5f5;">
		<div class="col-xs-6 col-md-6 col-lg-6" style="text-align: center; padding:15px;">
		<?php if (!isset($my_position)): ?>
		<button style="border-radius: 15px;" type='submit' name='status' value='1' class="button button-primary full-width" >参加する</button>
		<?php endif; ?>

		<?php if (isset($my_position) && $my_position['status'] == '0'): ?>
		<button style="border-radius: 15px;" type='submit' name='status' value='4' class="button button-primary full-width" >参加する</button>
		<?php endif; ?>

		<?php if (isset($my_position) && $my_position['status'] == '1'): ?>
		<button style="border-radius: 15px; background-color: #f5f5f5; color: black;" type='submit' name='status' value='3' class="button button-primary full-width">参加を取りやめる</button>
		<?php endif; ?>
	</div>
	<div class="col-xs-6 col-md-6 col-lg-6" style="text-align: center; padding:15px; border-radius: 30px;">
		<?php if (!isset($my_position)): ?>
		<button style="border-radius: 15px;" type='submit' name='status' value='2' class="button button-primary full-width" >興味がある</button>
		<?php endif; ?>
		<?php if (isset($my_position) && $my_position['status'] == '1'): ?>
		<button style="border-radius: 15px;" type='submit' name='status' value='5' class="button button-primary full-width" >興味がある</button>
		<?php endif; ?>
		<?php if (isset($my_position) && $my_position['status'] == '0'): ?>
		<button style="border-radius: 15px; background-color: #f5f5f5; color: black;" type='submit' name='status' value='3' class="button button-primary full-width">興味がない</button>
		<?php endif; ?>

		</div>
	</div>
</form>
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


<script>
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

//参加者表示のJS
// 現在の縦スクロール位置
var scrollPosition = document.getElementById("at_area").scrollTop;
// スクロール要素の高さ
var scrollHeight = document.getElementById("at_area").scrollHeight;
</script>



</body>

</html>