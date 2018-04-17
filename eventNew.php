<?php 
require('function.php');
login_check();
require('dbconnect.php');


if(!empty($_POST)){

	if($_POST['event_name'] == '' ){
	$error['event_name'] = 'blank';
	}
	if($_POST['edate'] == '' ){
	$error['edate'] = 'blank';
	}
	if($_POST['etime'] == '' ){
	$error['etime'] = 'blank';
	}
	if($_POST['shop_name'] == '' ){
	$error['shop_name'] = 'blank';
	}
	if($_POST['meeting_time'] == "" && $_POST['meeting_time_cal'] == ''){
	$error['meeting_time'] = 'blank';
	}
	if($_POST['meeting_time'] != "" && $_POST['meeting_time_cal'] != ''){
	$error['meeting_time'] = 'doubled';
	}
	if($_POST['meeting_place'] == '' ){
	$error['meeting_place'] = 'blank';
	}
	if($_POST['adate'] == '' ){
	$error['adate'] = 'blank';
	}
	if($_POST['atime'] == '' ){
	$error['atime'] = 'blank';
	}

 if (!isset($_POST['teachers'])) {$_POST['teachers'] = 0;}
 if (!isset($_POST['graduation'])) {$_POST['graduation'] = 0;}


//写真関係
//ショップの写真の引用と開催地がshopsにある際・ない際の処理
if(!empty($_POST['event_sp'])){
	if ($_POST['event_sp'] == '1') {
		$sql = 'SELECT `shop_pic` FROM `kami_shops` WHERE `shop_name`=? OR `shop_name_abc` = ?';
		$data = array($_POST['shop_name'] , $_POST['shop_name']);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);
		$event_picture = $stmt->fetch(PDO::FETCH_ASSOC);
		$event_picture = $event_picture["shop_pic"];
		if($event_picture == false){
		$error['kouho'] = 'kouho';
		}
	}
///ユーザーが写真をアップロードしていて、拡張子の都合がいい場合、悪い際の処理
	if ($_POST['event_sp'] == '2' && empty($_FILES['event_picture_user'])) {
	$error['event_picture_user'] = 'blank';
	}
	if ($_POST['event_sp'] == '2' && !empty($_FILES['event_picture_user'])) {
		$picture = substr($_FILES['event_picture_user']['name'], -3);
		$picture = strtolower($picture);
		if ($picture == 'jpg' || $picture == 'png' || $picture == 'gif') {
		$event_picture = date('YmdHis') . $_FILES['event_picture_user']['name'];
		move_uploaded_file($_FILES['event_picture_user']['tmp_name'], 'event_picture/'.$event_picture);}
		elseif ($picture != 'jpg' || $picture != 'png' || $picture != 'gif') {
		$error['event_picture_user'] = 'type';
		}
	}
	if ($_POST['event_sp'] == '3') {
		$event_picture = $_POST['event_picture_temp'];
	}
	if(empty($_POST['event_sp'])){
		$error['event_sp'] = 'blank';
	}
}

//集合時間の指定
//直接時間指定された場合
	if($_POST['meeting_time'] != "" && $_POST['meeting_time_cal'] == ''){
	$meet_time = $_POST['meeting_time'];
	!isset ($_POST['meeting_time_cal']);
	}
//何分前が押された場合の計算
	if($_POST['meeting_time'] == "" && $_POST['meeting_time_cal'] != ''){
	$cal = "-" . $_POST['meeting_time_cal'] . "minute";
	$cal = $_POST['etime'] . $cal;
	$meet_time = date( 'H:i', strtotime ( $cal ));
	!isset($_POST['meeting_time']);
	}
	$starttime = $_POST['edate'] ." ". $_POST['etime'];
	$answer_limitation = $_POST['adate'] ." ". $_POST['atime'];

//イベント詳細へのジャンプ用
	$jump_sql='SELECT `event_id` FROM `kami_events`ORDER BY `created` DESC LIMIT 1';
	$stmt = $dbh->prepare($jump_sql);
	$stmt->execute();
	$jump =$stmt -> fetch(PDO::FETCH_ASSOC);

	$_GET['id'] =  intval($jump['event_id']) + 1;

	if (!isset($error)) {
//イベント作成SQL
	$event_make_sql =' INSERT INTO `kami_events` SET `creater_id`	= ? , `event_name` = ?, `starttime` = ?, `event_place` = ?, `event_picture` = ?, `invite` = ?, `graduation` = ?, `teachers` = ?, `set_price` = ?, `detail` = ?, `meeting_time` = ?, `meeting_place` = ?, `max` = ?, `min` = ?, `answer_limitation` = ?, `created`=NOW(),`modified`= NOW()';
	$event_make_data = array( $_SESSION['id'], $_POST['event_name'], $starttime, $_POST['shop_name'], $event_picture, $_POST['invite'], $_POST['graduation'], $_POST['teachers'], $_POST['set_price'], $_POST['detail'], $meet_time, $_POST['meeting_place'], $_POST['max'], $_POST['min'], $answer_limitation);
	$event_make_stmt = $dbh->prepare($event_make_sql);
	$event_make_stmt->execute($event_make_data);

//イベント作成後、作成者を参加に指定
	$update_1_sql = 'INSERT INTO `kami_event_joinings` SET `member_id`=? , `event_id`=? ,`status` = 1 , `created` = NOW() , `modified` = NOW()';
	$update_1_data = array($_SESSION['id'],$_GET['id'],);
	$stmt = $dbh->prepare($update_1_sql);
	$stmt->execute($update_1_data); 

		header('Location: eventView.php?id='.$_GET['id']);

			exit;
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
   <link rel="stylesheet" href="css/jquery-ui.css">

        

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
               <li class="current"><a href="eventNew.php" title="">イベント作成</a></li>                          
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



<!-- end header -->

      <!-- header
   ================================================== -->


<div class ="container" style="padding-top: 150px; " >
	<form method="post" enctype="multipart/form-data">
	<div class="row" style="padding-top: 20px">
		<div class="col-xs-4 col-md-4 col-lg-4" >
			<h2 style>イベント名</h2>
		</div>
		<div class="col-xs-8 col-md-8 col-lg-8">
			<input type="text" name="event_name" >
			<?php if(isset($error['event_name']) && $error['event_name'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*イベント名を入力してください</p>
			<?php } ?>
		</div>
	</div>

	<div class="row" style="padding-top: 50px">
		<div class="col-xs-6 col-md-6  col-lg-4" >
			<h2 >開始時間</h2>
		</div>
		<div class="col-lg-8" >
			<input type="date" name="edate" min="" max="" style=" text-align: center;">
			<?php if(isset($error['edate']) && $error['edate'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*開催日を入力してください</p>
			<?php } ?>
			<input type="time" name="etime" step= "300" style=" text-align: center;">
			<?php if(isset($error['etime']) && $error['etime'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*開催時間を入力してください</p>
			<?php } ?>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>店名</h2>
		</div>
		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-4">
				<!-- 入力フォーム -->
				<input type="text" id="ac2" name="shop_name">
				</div>
				<div align="right" class="col-lg-2">
				<!-- <p>自由記入欄</p> -->
   			</div>
   			<div class="col-lg-4">
				<!-- <input type="text" name = "event_place" > -->
				</div>
				<div class="col-lg-2">
   			</div>
			</div>
		</div>
	</div>

<div class="row" style="padding-top: 50px ">
	<div class="col-lg-4" style="height: 12rem;">
		<h2 style=" margin-top: 0px; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">イベント写真</h2>
	</div>
	<div class="col-lg-8">
		<div class="row" style="height: 12rem;">
			<div class="col-lg-4" style=" top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
				<p style=' margin-bottom: 0px;'><input type='radio' name='event_sp' value='1'>お店の写真を使う</p>
				<?php if(isset($error['kouho']) && $error['kouho'] == 'kouho'){ ?>
				<p style="color:red; font-size: 15px;">*写真がありません。<br>ほかを指定してください。</p>
				<?php } ?>
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">
				<p style=" margin-bottom: 0px;"><input type="radio" name="event_sp" value='2'>自分で指定する</p>
				<input id="fileupload_file" type="file" name="event_picture_user">
				<?php if(isset($error['event_picture_user']) && $error['event_picture_user'] == 'type' ){ ?>
				<p style="color:red; font-size: 15px;">*jpg、png、gifのいずれかのファイルを選んでください。</p>
				<?php } ?>
				<?php if(isset($error['event_picture_user']) && $error['event_picture_user'] == 'blank' ){ ?>
				<p style="color:red; font-size: 15px;">*jpg、png、gifのいずれかのファイルを選んでください。</p>
				<?php } ?>
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
				<input type="radio" name="event_sp" value="3">
				<select name="event_picture_temp" style="display: inline; padding: 50px;">
					<option value=''>テンプレートから選ぶ</option>
					<option value="temp/graduation_party.png">卒業式</option>
					<option value="temp/happy_birthday.png">誕生日</option>
					<option value="temp/nomikai.png">飲み会</option>
				</select>
			</div>
		</div>
			<?php if(isset($error['event_sp']) && $error['event_sp'] == 'blank'){ ?>
				<div class="row">
					<div class="col-lg-12">
						<p style="color:red; font-size: 15px; margin-top:0px; ">*いずれかの写真を選んでください。</p>
					</div>
				</div>
			<?php } ?>
	</div>
</div>
	
	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2>招待  </h2>
		</div>
		<div class="col-lg-8" >
			<input type="text" name='invite'>
		</div>
	</div>


	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4"  style="height: 12rem;">
			<h2 style=" margin-top: 0px; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">タグ</h2>
		</div>
		<div class="col-lg-8" >
			<div class="row" style="height: 12rem;">
			<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
				<p><input type="checkbox" name="teachers" value="1"> <span>先生も参加する</span></p>
			</div>
				<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">
					<p><input type="checkbox" name="graduation" value="1"> <span>グラパ</span></p>
			</div>
				<div class="col-lg-5" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
					<p>金額指定する 約
					<select name="set_price" style="display: inline;" type="checkbox">
						<option value="指定なし">選択してください↓</option>
						<option value="~200ペソ">〜200ペソ</option>
						<option value="200〜300ペソ">200〜300ペソ</option>
						<option value="300〜400ペソ">300〜400ペソ</option>
						<option value="400〜500ペソ">400〜500ペソ</option>
						<option value="500〜ペソ">500〜ペソ</option>
						<!-- <option value="0">スマイル</option> -->
					</select></p>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2 >詳細</h2>
		</div>
		<div class="col-xs-8 col-md-8 col-lg-8">
			<textarea style="resize:vertical;" name= "detail" class="full-width" placeholder="詳細" ></textarea>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>集合時間</h2>
	</div>
	<div class="col-lg-8">
			<h2 style="display: inline;"><input type="time" name="meeting_time" step= "300" style=" text-align: center;">または<input type="number" name="meeting_time_cal" min="0" max="60" step="5" style=" text-align: center;">分前</h2>
			<?php if(isset($error['meeting_time']) && $error['meeting_time'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*集合時間を入力してください</p>
			<?php } ?>
			<?php if(isset($error['meeting_time']) && $error['meeting_time'] == 'doubled'){ ?>
			<p style="color:red; font-size: 15px;">*入力はどちらかにしてください</p>
			<?php } ?>
	</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
	
		<div class="col-lg-4" >
			<h2>集合場所</h2>
			</div>
	<div class="col-lg-8" >
		<input type="text" name="meeting_place" >
		<?php if(isset($error['meeting_place']) && $error['meeting_place'] == 'blank'){ ?>
		<p style="color:red; font-size: 15px;">*集合場所を入力してください</p>
		<?php } ?>

			</div>
		
	</div>




	<div class="row" style="padding-top: 60px;" >
			<div class="col-lg-4" >
				<h2 >参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MAX <input type="number" name="max" min="0" max="150" step="5" style="text-align: center;" value="0"></h2>
			</div>
			<div class="col-lg-4" >
				<h2 >最低参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MIN<input type="number" name="min" min="0" max="150" step="1" style="text-align: center;" value="0"></h2>
			</div>
			<div class="col-lg-4">
			<h2>回答期限</h2>
			<input type="date" name="adate" min="<?php echo $Dmin ?>" max="<?php echo $Dmx ?>" style=" text-align: center;">
			<?php if(isset($error['adate']) && $error['adate'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*回答期限日を入力してください</p>
			<?php } ?>
			<input type="time" name="atime" step= "300" style=" text-align: center;">
			<?php if(isset($error['atime']) && $error['atime'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*回答期限時間を入力してください</p>
			<?php } ?>
				</div>
		</div>
		</div>
	</div>
	<div class ="container full-width">
		<div class="row  background-color: #f5f5f5;">
				<div class="col-lg-6" style="text-align: center; padding:50px; border-radius: 15px; ">
					<a class="button button-primary full-width" href="index.html" style=" border-radius: 15px; ">キャンセル</a>
				</div>
				<div class="col-lg-6" style="text-align: center;padding:50px; border-radius: 15px; "> <input class="button button-primary full-width" type="submit" value="作成する" style="border-radius: 15px;" >
					</div>

		</div>
</div>
</form>
</div>




   <!-- content
   ================================================== -->  



   


   
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
   <script type="text/javascript" src="js/jquery-ui.js">
    </script>
    <script>$(document).ready( function() {
$("#ac2").autocomplete({
  source: function(req, resp){
    $.ajax({
        url: "autocomplete-datasource.php",
        type: "POST",
        cache: false,
        dataType: "json",
        data: {
          param1: req.term
        },
        success: function(o){
          resp(o);
        },
        error: function(xhr, ts, err){
          resp(['']);
        }
      });

  }
});
});</script>
</body>

</html>