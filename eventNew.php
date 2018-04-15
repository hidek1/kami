<?php 
require('function.php');
login_check();
require('dbconnect.php');

//実装
//店検索
//写真アップロード



//var_dump($hoge) ;
//echo('</pre>');

//
if (!empty($_POST)) {
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

	if (!isset($error)) {
	$starttime = $_POST['edate'] ." ". $_POST['etime'];
	$answer_limitation = $_POST['adate'] ." ". $_POST['atime'];

	if($_POST['meeting_time'] != "" && $_POST['meeting_time_cal'] == ''){
	$meet_time = $_POST['meeting_time'];
	}
//何分前が押された場合の計算
	if($_POST['meeting_time'] == "" && $_POST['meeting_time_cal'] != ''){
	$cal = "-" . $_POST['meeting_time_cal'] . "minute";
	$cal = $_POST['etime'] . $cal;
	$meet_time = date( 'H:i', strtotime ( $cal ));
	}
	$event_make_sql =' INSERT INTO `kami_events` SET `creater_id`	= ? , `event_name` = ?, `starttime` = ?, `event_place` = ?, `event_picture` = ?, `invite` = ?, `graduation` = ?, `teachers` = ?, `set_price` = ?, `detail` = ?, `meeting_time` = ?, `meeting_place` = ?, `max` = ?, `min` = ?, `answer_limitation` = ?, `created`=NOW(),`modified`= NOW()';
	$event_make_data = array( $_SESSION['id'], $_POST['event_name'], $starttime, $_POST['event_place'], $_POST['event_picture'], $_POST['invite'], $_POST['graduation'], $_POST['teachers'], $_POST['set_price'], $_POST['detail'], $meet_time, $_POST['meeting_place'], $_POST['max'], $_POST['min'], $answer_limitation);
	$event_make_stmt = $dbh->prepare($event_make_sql);
	$event_make_stmt->execute($event_make_data);
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
	<form method="POST">
	<div class="row" style="padding-top: 20px">
		<div class="col-xs-4 col-md-4 col-lg-4" >
			<h2 style>イベント名</h2>
		</div>
		<div class="col-xs-8 col-md-8 col-lg-8">
			<input type="text" name = "event_name" >
			<?php if(isset($error) && $error['event_name'] == 'blank'){ ?>
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
			<?php if(isset($error) && $error['edate'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*開催日を入力してください</p>
			<?php } ?>
			<input type="time" name="etime" step= "300" style=" text-align: center;">
			<?php if(isset($error) && $error['etime'] == 'blank'){ ?>
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
			<p style=" margin-bottom: 0px;"><input type="checkbox"><span>お店の写真を使う</span></p>
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<input type="file" name="event_picture">
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<input type="text" list="data1">
			</div>
		</div>
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
		<div class="col-lg-8">
			<textarea name= "detail"class="full-width" placeholder="詳細" ></textarea>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>集合時間</h2>
	</div>
	<div class="col-lg-8">
			<h2 style="display: inline;"><input type="time" name="meeting_time" step= "300" style=" text-align: center;">または<input type="number" name="meeting_time_cal" min="0" max="60" step="5" style=" text-align: center;">分前</h2>
			<?php if(isset($error) && $error['meeting_time'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*集合時間を入力してください</p>
			<?php } ?>
			<?php if(isset($error) && $error['meeting_time'] == 'doubled'){ ?>
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
		<?php if(isset($error) && $error['meeting_place'] == 'blank'){ ?>
		<p style="color:red; font-size: 15px;">*集合場所を入力してください</p>
		<?php } ?>

			</div>
		
	</div>




	<div class="row" style="padding-top: 60px;" >
			<div class="col-lg-4" >
				<h2 >参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MAX <input type="number" name="max" min="0" max="150" step="5" style="text-align: center;"></h2>
			</div>
			<div class="col-lg-4" >
				<h2 >最低参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MIN<input type="number" name="min" min="0" max="150" step="5" style="text-align: center;"></h2>
			</div>
			<div class="col-lg-4">
			<h2>回答期限</h2>
			<input type="date" name="adate" min="<?php echo $Dmin ?>" max="<?php echo $Dmx ?>" style=" text-align: center;">
			<?php if(isset($error) && $error['adate'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*回答期限日を入力してください</p>
			<?php } ?>
			<input type="time" name="atime" step= "300" style=" text-align: center;">
			<?php if(isset($error) && $error['atime'] == 'blank'){ ?>
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