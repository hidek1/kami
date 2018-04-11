<?php 
//getで編集するイベントを指定
//update or delete
 ?>


<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="ja"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
	<meta charset="utf-8">
	<title>イベントの編集</title>
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
                  <a href="shop_list.php" title="">お店</a>
               </li>
       <li class="has-children">
                  <a href="Profile.php" title="">マイページ</a>
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





<div class ="container" style="padding-top: 160px; " >
	<form action="POST">
	<div class="row" style="padding-top: 20px">
		<div class="col-lg-4" >
			<h2 style>イベント名</h2>
		</div>
		<div class="col-lg-8">
			<input type="text" name = "Name" >
		</div>
	</div>

	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2 >開始時間</h2>
		</div>
		<div class="col-lg-8" >
			<input type="date" name="startDate" min="<?php echo $Dmin ?>" max="<?php echo $Dmax ?>" style=" text-align: center;">
			<input type="time" name="startTime" step= "300" style=" text-align: center;">
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>店名</h2>
		</div>
		<div class="col-lg-8">
			<div class="row">
					<div class="col-lg-4">
					<input type="text" name = "Name" >
					</div>
				<div align="right" class="col-lg-2">
					<p>自由記入欄</p>
    </div>
    <div class="col-lg-4">
					<input type="text" name = "Name" >
				</div>
    <div class="col-lg-2">
    </div>
			</div>
		</div>
	</div>

<div class="row" style="padding-top: 50px">
	<div class="col-lg-4">
		<h2 >イベント写真</h2>
	</div>
	<div class="col-lg-8">
		<div class="row" style="height: 12rem;">
			<div class="col-lg-4" style=" top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<p><input type="checkbox"><span>お店の写真を使う</span></p>
			</div>
			<div class="col-lg-4" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%); ">
			<input type="file">
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
			<input type="text">
		</div>
	</div>


	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2>タグ</h2>
		</div>
		<div class="col-lg-8" >
			<div class="row" style="height: 12rem;">
			<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
				<p><input  type="checkbox"> <span>先生も参加する</span></p>
			</div>
				<div class="col-lg-3" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">
					<p><input type="checkbox"> <span>グラパ</span></p>
			</div>
				<div class="col-lg-5" style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);" >
					<p><input style="display: inline;" type="checkbox"> 金額指定する 約<input type="text" style="display: inline; height: 30px;width: 80px; padding: 5px 2px	;"><span>pesos</span></p>
			</div>
			</div>
		</div>
	</div>

	<div class="row" style="padding-top: 50px">
		<div class="col-lg-4" >
			<h2 >詳細</h2>
		</div>
		<div class="col-lg-8">
			<textarea class="full-width" placeholder="詳細" ></textarea>
		</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
		<div class="col-lg-4">
			<h2>集合時間</h2>
	</div>
	<div class="col-lg-8">
			<h2 style="display: inline;"><input type="time" name="star	tTime" step= "300" style=" text-align: center;">または<input type="number" name="sampleNumber" min="0" max="60" step="5" style=" text-align: center;">分前</h2>
	</div>
	</div>

	<div class="row" style="padding-top: 60px;" >
	
		<div class="col-lg-4" >
			<h2>集合場所</h2>
			</div>
	<div class="col-lg-8" >
		<input type="text" name="" >
			</div>
		
	</div>




	<div class="row" style="padding-top: 60px;" >
			<div class="col-lg-4" >
				<h2 >参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MAX <input type="number" name="sampleNumber" min="0" max="150" step="5" style="text-align: center;"></h2>
			</div>
			<div class="col-lg-4" >
				<h2 >最低参加人数</h2>
				<h2 style="display: inline; top: 50%;position: relative; top: 50%; -webkit-transform: translateY(-50%); /* Safari用 */ transform: translateY(-50%);">MIN<input type="number" name="sampleNumber" min="0" max="150" step="5" style="text-align: center;"></h2>
			</div>
			<div class="col-lg-4">
			<h2>回答期限</h2>
			<input type="date" name="startDate" min="<?php echo $Dmin ?>" max="<?php echo $Dmax ?>" style=" text-align: center;">
			<input type="time" name="startTime" step= "300" style=" text-align: center;"></p>
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

</body>

</html>