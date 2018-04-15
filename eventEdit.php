<?php 

	require('dbconnect.php');
	session_start();

//表示用
	$event_sql='SELECT * FROM `kami_events` WHERE `event_id` = ? ';
	$event_data= array($_GET['id']);
	$stmt = $dbh->prepare($event_sql);
	$stmt->execute($event_data);
	$event =$stmt -> fetch(PDO::FETCH_ASSOC);

//開始時間の分離と表示
	$pre_starttime = $event['starttime'];
	$smd = substr($pre_starttime, 0, 10);
	$shm =  date("H:i", strtotime($pre_starttime));

// 集合時間の分離と表示
	$pre_meet_time = $event['meeting_time'];
	$mhm = date("H:i", strtotime($pre_meet_time));

//回答期限の分離と表示
	$ltime= $event['answer_limitation'];
	$lmd = substr($pre_starttime, 0, 10);
	$lhm =  date("H:i", strtotime($ltime));

//一旦保存
 $pre_eventname = $event['event_name'];
 $pre_event_place = $event['event_place'];
 $pre_event_picture = $event['event_picture'];
 $pre_invite = $event['invite'];
 $pre_graduation = $event['graduation'];
 $pre_teachers = $event['teachers'];
 $pre_set_price = $event['set_price'];
 $pre_detail = $event['detail'];
 $pre_meeting_place = $event['meeting_place'];
 if (!isset($event['max'])) {$pre_max = 0;
 }
 if (isset($event['max'])) {
 $pre_max = $event['max'];
 }

 if (!isset($event['min'])) {$pre_min = 0;
 }
 if (isset($event['min'])) {
 $pre_min = $event['min'];
 }



 

echo('<pre>');
var_dump($event) ;
echo('</pre>');

if (!empty($_POST)) {
	if ($pre_eventname == '' ){
	$error['event_name'] = 'blank';
	}
	if ($_POST['pattern'] == '') {
	$error['event_place'] = 'blank';
	}




//写真関係
//写真の判定をすべてチェックでやるのか。。。悩みどころ
	if(isset($_FILES['event_picture_user'])){
		$picture = substr($_FILES['event_picture_user']['name'], -3);
  	$picture = strtolower($picture);
 		if ($picture == 'jpg' || $picture == 'png' || $picture == 'gif') {
		$event_picture = date('YmdHis') . $_FILES['event_picture_user']['name'];
		move_uploaded_file($_FILES['event_picture_user']['tmp_name'], 'event_picture/'.$event_picture);}
		if ($picture != 'jpg' || $picture != 'png' || $picture != 'gif') {
		$error['event_picture_user'] = 'type';
		
		$com_event_picture = $event_picture;
		}
	}


	// if ($_POST['event_picture_temp'] != '') {
	// 	if(isset($_FILES['event_picture_user'])){
	// 		!isset($_FILES['event_picture_user']);}
	// 	$event_picture = $_POST['event_picture_temp'];
	// }



	if (!isset($error)) {
	//開始時間の連結
	$com_starttime = $_POST['edate'] ." ". $_POST['etime'];

//回答期限の連結
	$com_answer_limitation = $_POST['adate'] ." ". $_POST['atime'];

//集合時間の連結
//直接指定された場合
	if ($_POST['meeting_time'] == "" && $_POST['meeting_time_cal'] == '') {
	$com_meet_time = $pre_meet_time;
	}
	if($_POST['meeting_time'] != "" && $_POST['meeting_time_cal'] == ''){
	$meet_time = $_POST['meeting_time'];
	$com_meet_time = $meet_time;
	}
//何分前が押された場合の計算
	if( $_POST['meeting_time_cal'] != '' ){
	$cal = "-" . $_POST['meeting_time_cal'] . "minute";
	$cal = $_POST['etime'] . $cal;
	$meet_time = date( 'H:i', strtotime ( $cal ));
	$com_meet_time = $meet_time;
	}

 $com_eventname = $_POST['event_name'];
 $com_event_place = $_POST['pattern'];
 $com_invite = $_POST['invite'];
 $com_graduation = $_POST['graduation'];
 $com_teachers = $_POST['teachers'];
 $com_set_price = $_POST['set_price'];
 $com_detail = $_POST['detail'];
 $com_meeting_place = $_POST['meeting_place'];
 $com_min = $_POST['min'];
 $com_max = $_POST['max'];

	$event_edit_sql =' UPDATE  `kami_events` SET  `event_name` = ?, `starttime` = ?, `event_place` = ?, `event_picture` = ?, `invite` = ?, `graduation` = ?, `teachers` = ?, `set_price` = ?, `detail` = ?, `meeting_time` = ?, `meeting_place` = ?, `max` = ?, `min` = ?, `answer_limitation` = ?, `modified`= NOW() WHERE `event_id` = ? ';
	$event_edit_data = array( $com_eventname, $com_starttime, $com_event_place, $com_event_picture, $com_invite, $com_graduation, $com_teachers, $com_set_price, $com_detail, $com_meet_time, $com_meeting_place, $com_max, $com_min, $com_answer_limitation,$_GET['id']);
	$event_edit_stmt = $dbh->prepare($event_edit_sql);
	$event_edit_stmt->execute($event_edit_data);



}
 }


 ?>


<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>
  <script>
    window.onload = function startSuggest() {
  new Suggest.Local(
        "text",    // 入力のエレメントID
        "suggest", // 補完候補を表示するエリアのID
        list,      // 補完候補の検索対象となる配列
        {dispMax: 10, interval: 1000}); // オプション
}

window.addEventListener ?
  window.addEventListener('load', startSuggest, false) :
  window.attachEvent('onload', startSuggest);
  </script>
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
	<form method="POST" enctype="multipart/form-data">
	<div class="row" style="padding-top: 20px">
		<div class="col-xs-4 col-md-4 col-lg-4" >
			<h2 style>イベント名</h2>
		</div>
		<div class="col-xs-8 col-md-8 col-lg-8">
			<?php echo ("<input value = '$pre_eventname' type='text' name = 'event_name'>"); ?>
			
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
			<?php echo("<input value = '$smd' type='date' name='edate' min=' max=' style=' text-align: center;'>" );?>
			<?php echo("<input value = '$shm' type='time' name='etime' step= '300' style=' text-align: center;'>"); ?>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>店名</h2>
		</div>
		<div class="col-lg-8">
				<table>
  			  <tr>
  			    <td>入力:</td>
  			    <td>
  			      <!-- 入力フォーム -->
  			      <?php echo("<input  value = '$pre_event_place' id='text' type='text' 			name='pattern'  autocomplete='off' size='10' style='display: block'>"); ?>
  			      <!-- 補完候補を表示するエリア -->
  			      <div id="suggest" style="display:none;"></div>
  			    </td>
  			  </tr>
  		</table>
  		<?php if(isset($error) && $error['event_place'] == 'blank'){ ?>
			<p style="color:red; font-size: 15px;">*入力してください</p>
			<?php } ?>
		</div>
	</div>

<div class="row" style="padding-top: 50px ">
	<div class="col-lg-4" style="height: 12rem;">
		<h2 style=" margin-top: 0px; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">イベント写真</h2>
	</div>
	<div class="col-lg-8">
		<div class="row" style="height: 12rem;">
			<div class="col-lg-4" style=" top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<p style=" margin-bottom: 0px;"><input type="checkbox" name="">お店の写真を使う</p>
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
				<p style=" margin-bottom: 0px;"><input type="checkbox" name="">自分で指定する</p>
			<?php echo"<input id='fileupload_file' type='file' name='event_picture_user' value='$pre_event_picture'>" ?>
			<?php if(isset($error['event_picture_user']) && $error['event_picture_user'] == 'type'){ ?>
			<p style="color:red; font-size: 15px;">*jpg、png、gifのいずれかの拡張子を選んでください。</p>
			<?php } ?>

			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
				<select name="event_picture_temp" style="display: inline; padding: 50px;">
						<option value=''>いろんな写真</option>
						<option value="temp/graduation_party.png">卒業式</option>
						<option value="temp/happy_birthday.png">誕生日</option>
						<option value="temp/nomikai.png">飲み会</option>
					</select></p>
			</div>
		</div>
	</div>
</div>
	
	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2>招待  </h2>
		</div>
		<div class="col-lg-8" >
			<?php echo("<input type='text' name='invite' value = '$pre_invite'>"); ?>
		</div>
	</div>

	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4"  style="height: 12rem;">
			<h2 style=" margin-top: 0px; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">タグ</h2>
		</div>
		<div class="col-lg-8" >
			<div class="row" style="height: 12rem;">
			<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
				<p><input type="checkbox" name="teachers" value="1" <?php if ( $pre_teachers == 1): ?> checked<?php endif; ?> > <span>先生も参加する</span></p>
			</div>
				<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">
					<p><input type="checkbox" name="graduation" value="1" <?php if ($pre_graduation == 1): ?> checked <?php endif; ?>	> <span>グラパ</span></p>
			</div>
				<div class="col-lg-5" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
					<p>金額指定する 約
					<select name="set_price" style="display: inline;"" type="checkbox" >
						<?php if ($pre_set_price != "指定なし"): ?>
						<option value="<?php echo $pre_set_price;?>" selected ><?php echo $pre_set_price;?></option>
						<?php endif; ?>
						<option value="指定なし">指定しない↓</option>
						<option value="~200ペソ">〜200ペソ</option>
						<option value="200〜300ペソ">200〜300ペソ</option>
						<option value="300〜400ペソ">300〜400ペソ</option>
						<option value="400〜500ペソ">400〜500ペソ</option>
						<option value="500〜ペソ"	>500〜ペソ</option>
						<option value="指定なし">スマイル</option>
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
			<?php echo("<textarea name= 'detail' class='full-width'>$pre_detail</textarea>"); ?>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>集合時間 </h2>
	</div>
	<div class="col-lg-8">
			<p style="font-size: 28px;"> 
			<h2 style="display: inline;"><?php echo("<input type='time' name='meeting_time' step= '300' style=' text-align: center;' value='$mhm'>"); ?>または、開始時間の<input type="number" name="meeting_time_cal" min="0" max="60" step="5" style=" text-align: center;">分前</h2>
	</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
	
		<div class="col-lg-4" >
			<h2>集合場所</h2>
			</div>
	<div class="col-lg-8" >
		<?php echo("<input type='text' name='meeting_place' value = '$pre_meeting_place'>") ?>
		<?php if(isset($error) && $error['meeting_place'] == 'blank'){ ?>
		<p style="color:red; font-size: 15px;">*集合場所を入力してください</p>
		<?php } ?>

			</div>
		
	</div>




	<div class="row" style="padding-top: 60px;" >
			<div class="col-lg-4" >
				<h2 >参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MAX <?php echo("<input type='number' name='max' min='0' max='150' step='5' style='text-align: center;' value = '$pre_max'>"); ?></h2>
			</div>
			<div class="col-lg-4" >
				<h2 >最低参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MIN<?php echo("<input type='number' name='min' min='0' max='150' step='1' style='text-align: center;' value = '$pre_min'>"); ?></h2>
			</div>
			<div class="col-lg-4">
			<h2>回答期限</h2><?php echo("<input type='date' name='adate'  max='$smd' style=' text-align: center;' value = '$lmd'>"); ?>
			<?php echo("<input type='time' name='atime' step= '300' style=' text-align: center;' value = '$lhm'>"); ?>
				</div>
		</div>
		</div>
	</div>
	<div class ="container full-width">
		<div class="row  background-color: #f5f5f5;">
				<div class="col-lg-6" style="text-align: center; padding:50px; border-radius: 15px; ">
					<a class="button button-primary full-width" href="eventView.php?id=<?php echo $_GET['id']; ?>" style=" border-radius: 15px; ">キャンセル</a>
				</div>
				<div class="col-lg-6" style="text-align: center;padding:50px; border-radius: 15px; "> <input class="button button-primary full-width" type="submit" value="編集を終了する" style="border-radius: 15px;" action="eventView.php?id=<?php echo $_GET['id']; ?>" >
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
   <script src="js/suggest.js"></script>


</body>

</html>