<?php
//今後
	//写真の表示
	//興味ユーザーの作成
require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');
//詳細を見るイベントの表示


//ホームや一覧からの表示
	$event_sql='SELECT * FROM `kami_events` WHERE `event_id` = ? ';
	$event_data= array($_GET['id']);
	$stmt = $dbh->prepare($event_sql);
	$stmt->execute($event_data);
	$event =$stmt -> fetch(PDO::FETCH_ASSOC);

//レビュー関係の取得
	$sql = 'SELECT * FROM `kami_shops` WHERE `shop_name`=? or `shop_name_abc`=?';
	//本番用
	$data = array($event['event_place'],$event['event_place']);
	//練習
	// $data = array('jfさlkjfdさljf','ふぁsfだshfはskふぁhds');
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);
	$store_detail = $stmt->fetch(PDO::FETCH_ASSOC);
if ($store_detail == true) {

	$sql = 'SELECT * FROM `kami_reviews` WHERE `shop_id`=? ORDER BY `review_created` DESC';
	$data = array($store_detail['shop_id']);
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);
	$records = array();
	$pictures = array();
	while (true) {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  if($record["review_picture"] != ''){
  $pictures[] = $record["review_picture"];
  }
  if($record["review_picture2"] != ''){
  $pictures[] = $record["review_picture2"];
  }
  if($record["review_picture3"] != ''){
  $pictures[] = $record["review_picture3"];
  }
  if($record["review_picture4"] != ''){
  $pictures[] = $record["review_picture4"];
  }
  if($record == false){
		break;
  }
  $records[] = $record;
	}
	}
	if($store_detail == false ){
  $caution = 'no_pic' ;
}




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
	<title>イベントの詳細</title>
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

<body id="top" style="background-color: whitesmoke;">




 
<?php 
require('header.php');
?>
　　　	<link rel="stylesheet" href="css/eventview_main.css" />

<!-- One -->
					<section class="banner style1 orient-left content-align-left fullscreen onload-image-fade-in onload-content-fade-right" style="padding-top: 120px;">
							
						<div class="content">
		<!-- 					<?php if ($event['max'] != 0 && count($attends) >= $event['max']):?>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12" style="text-align:center;">
				<img src="event_picture/temp/mannin.png" height="100" >
			</div>
		</div>
	<?php endif; ?> -->
							<h1><?php echo $event['event_name'] ;?>@<a href="http://localhost/kami/store_details.php?name=<?php echo $event['event_place'] ?>&name_abc=<?php echo $event['event_place'] ?>"><?php echo $event['event_place'] ;?></a></h1>
							<p class="major">MIN: <?php echo $event['min']; ?>

				MAX: <?php echo $event['max']; ?>
				<br>invite: @<?php echo $event['invite'] ;?><br>DeadLine: 
				<?php 
				$limit = $event['answer_limitation'];
				$limit = date("m-d H:i", strtotime($limit));
				echo $limit ;?><br>DATE:    <?php
				$starttime = $event['starttime'];
				$starttime = date("m-d H:i", strtotime($starttime));
				echo $starttime ;?>~<br>MEET AT: <?php 
			$meeting_time = $event['meeting_time'];
			$meeting_time = date(" H:i", strtotime($meeting_time));
			echo $meeting_time ;?> @<?php echo $event['meeting_place'] ;?><br>TAG: <?php if ($event['graduation'] == 1) {?>
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
				<?php } ?><br>Note: <?php echo $event['detail'] ;?></p>
						</div>
						<div class="image" style="margin-top: 4rem;">
							<img src="event_picture/<?php echo $event['event_picture'] ?>" alt="" />
						</div>
					</section>

	<!-- Gallery -->
							<div class="gallery style2 medium lightbox onscroll-fade-in" style="margin-top: 120px">
								<?php if (!isset($caution) && !empty($pictures)): ?>
				<?php foreach ($pictures as $pic): ?>
								<article>
									<a href="review_picture/<?php echo $pic ?>" class="image">
										<img src="review_picture/<?php echo $pic ?>" alt=""  style="height: 430px; object-fit: cover;"/>
									</a>
									<div class="caption">
										<h3>Ipsum Dolor</h3>
										<p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
										<ul class="actions">
											<li><span class="button small">Details</span></li>
										</ul>
									</div>
								</article>
        <?php endforeach ?>
				<?php endif ?>
							</div>


						
    

					<section class="spotlight style1 orient-left content-align-left image-position-center onscroll-image-fade-in">
						<div class="content">
							<div class ="container" style="padding-top: 20px;" >
	<div class="row">
		<div class="col-xs-6 col-md-6 col-lg-6" >
			<h3 style=" font-weight: 300;">Attending(<?php echo count($attends);?>)</h3>
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
			<h3 style=" font-weight: 300;">Interested(<?php echo count($interests);?>)</h3>
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
				<?php if($event['max'] == 0 || count($attends) < $event['max']): ?>
				<button style="border-radius: 15px; background-color: lightgray; color: black;" type='submit' name='status' value='1' class="button button-primary full-width" >参加する</button>
				<?php endif; ?>
				<?php if (count($attends) >= $event['max']): ?>
				<button style="border-radius: 15px; background-color: #f5f5f5; color: black;" class="button button-primary full-width" >参加できません</button>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (isset($my_position) && $my_position['status'] == '0'): ?>
				<?php if( $event['max'] == 0 || count($attends) < $event['max']): ?>
				<button style="border-radius: 15px; background-color: lightgray; color: black;" type='submit' name='status' value='4' class="button button-primary full-width" >参加する</button>
				<?php endif; ?>
				<?php if (count($attends) >= $event['max']): ?>
				<button style="border-radius: 15px; background-color: #f5f5f5; color: black;" class="button button-primary full-width" >参加できません</button>
				<?php endif; ?>
			<?php endif; ?>
			<?php if (isset($my_position) && $my_position['status'] == '1'): ?>
				<button style="border-radius: 15px; background-color: lightgray; color: black;" type='submit' name='status' value='3' class="button button-primary full-width">参加を取りやめる</button>
			<?php endif; ?>
		</div>
		<div class="col-xs-6 col-md-6 col-lg-6" style="text-align: center; padding:15px; border-radius: 30px;">
			<?php if (!isset($my_position)): ?>
				<button style="border-radius: 15px; background-color: white; color: black;" type='submit' name='status' value='2' class="button button-primary full-width" >興味がある</button>
			<?php endif; ?>
			<?php if (isset($my_position) && $my_position['status'] == '1'): ?>
			<button style="border-radius: 15px; background-color: white; color: black;" type='submit' name='status' value='5' class="button button-primary full-width" >興味がある</button>
			<?php endif; ?>
			<?php if (isset($my_position) && $my_position['status'] == '0'): ?>
			<button style="border-radius: 15px; background-color: white; color: black;" type='submit' name='status' value='3' class="button button-primary full-width">興味がない</button>
			<?php endif; ?>
		</div>
	</div>
</form>
</div>
						</div>
					</section>





   


   
   <!-- footer
   ================================================== -->
 

   	 <footer>
<center>
<p class="keigo" style="font-size: 18px;"><span>© kami 2018</span> 
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
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.scrollex.min.js"></script>
			<script src="js/jquery.scrolly.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<script src="js/eventview_main.js"></script> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script>
   <script src="js/modal.js"></script>
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