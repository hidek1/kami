<?php 
require('function.php');
login_check();
require('dbconnect.php');

$sql = 'SELECT * FROM `kami_members` WHERE `member_id`=?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $profile_edit = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($profile_edit);
if (!empty($_POST)){


   if ($_POST['nickname']=='') {
   $error['nickname']='blank';
  }

  if ($_POST['room_number']=='') {
   $error['room_number']='blank';
  }

  if ($_POST['stay_start']=='') {
   $error['stay_start']='blank';
  }

  if ($_POST['stay_finish']=='') {
   $error['stay_finish']='blank';
  }

  $nickname = htmlspecialchars($_POST['nickname']);
  $room_number = htmlspecialchars($_POST['room_number']);
  $stay_start = htmlspecialchars($_POST['stay_start']);
  $stay_finish = htmlspecialchars($_POST['stay_finish']);
  $comment = htmlspecialchars($_POST['comment']);

// var_dump($_FILES);

  if (!isset($error)) {
 
    if (!empty($_FILES["files"]["error"])) {
     $picture_path="01.jpg";

     $sql = 'UPDATE `kami_members` SET `nickname`=?,`room_number`=?,`picture_path`=?,`stay_start`=?,`stay_finish`=?,`comment`=?,`modified`=NOW() WHERE `member_id`=?';
$data = array($nickname , $room_number , $picture_path , $stay_start , $stay_finish , $comment , $_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header('Location:Profile.php');
exit();

  }else{
    $ext=substr($_FILES['files']['name'], -3);
    $ext=strtolower($ext);
    if ($ext=='jpg' || $ext=='png') {
    $picture_path=date('YmdHis').$_FILES['files']['name'];
    // var_dump($_FILES['picture_path']['tmp_name']);

// permissionと絶対パス
 move_uploaded_file($_FILES['files']['tmp_name'], 'picture_path/'.$picture_path);

 $sql = 'UPDATE `kami_members` SET `nickname`=?,`room_number`=?,`picture_path`=?,`stay_start`=?,`stay_finish`=?,`comment`=?,`modified`=NOW() WHERE `member_id`=?';
$data = array($nickname , $room_number , $picture_path , $stay_start , $stay_finish , $comment , $_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header('Location:Profile.php');
exit();


    } else {
    $error['picture_path']='type';
      }
    }
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
  <title>Category Page - Abstract</title>
  <meta name="description" content="">  
  <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/base.css">
   <link rel="stylesheet" href="css/vendor.css">  
   <link rel="stylesheet" href="css/profile_profileedit_main.css">

   <link rel="stylesheet" href="css/ange_bootstrap.css">

        

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



   <!-- page header
   ================================================== -->
   

  <section id="page-header">
  
         
          <center>
            <h1>プロフィール編集</h1>
           </center>
        
    
   </section>

<form name="" id="a" method="post" action="" enctype="multipart/form-data">
<section>
                    
                      
 


  <div class="container">
                       <div class="row">
      <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                        <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
                         

                          <div class="input_file">
    <div class="preview">
        <input accept="image/*" id="imgFile" name="files" type="file">
    </div>
    <p class="btn_upload">
        画像ファイルを選択してアップロード
    </p>
</div>

                        
                       </div>
    <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                       </div>
                     </div>

                     <div class="container">
                       <div class="row">
                         <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                         <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
                          <h3>ニックネーム</h3>
                                <input name="nickname" type="text" id="cName" class="full-width" placeholder="" value="<?php echo $profile_edit["nickname"]; ?>">
                     </div>
                      <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                   </div>
                  </div>



                        
                    
                    
 <div class="container">
                     <div class="row">
                       <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                       <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
                        <h3>部屋番号</h3>
                                <input name="room_number" type="text" id="cName" class="full-width" placeholder="" value="<?php echo $profile_edit["room_number"]; ?>">
                     </div>
                      <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                   </div>
                  </div>

                      
                     <div class="container">
                        <div class="row">
                           <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                          <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
                            <h3>滞在期間</h3>
                                from
       <input name="stay_start" type="date" id="cName" class="half-width" value="<?php echo $profile_edit["stay_start"]; ?>">
  to
       <input name="stay_finish" type="date" id="cName" class="half-width" value="<?php echo $profile_edit["stay_finish"]; ?>">
                     </div>
                      <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                   </div>
                 </div>
                
    



                   
                   
                 


                    



                    
                     <div class="container">
                      <div class="row">
                         <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                        <div class="col-xs-6 col-md-6 col-lg-6" style="background-color: white;margin:15px;">
                             <h3>コメント</h3>

                                <input name="comment" type="text" id="a" class="full-width" placeholder="Comment" value="<?php echo $profile_edit["comment"]; ?>">
                     </div>
                      <div class="col-xs-3 col-md-3 col-lg-3">
</div>
                   </div>
                 </div>
                


                     
                     </section>

                     <center>
                     <button type="submit" class="submit button-primary">Edit</button>
                     </center>

</form>


   <center>
   <footer>
                 
             
                  <p class="keigo"><span>© kami 2018</span> 
                  <span>by team pelo</a></span></p>              
             
                <!-- end footer-bottom -->  
   </footer>  
 </center>

   <div id="preloader"> 
      <div id="loader"></div>
   </div> 

   

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script>
   <script>$('#imgFile').change(
    function () {
        if (!this.files.length) {
            return;
        }

        var file = $(this).prop('files')[0];
        var fr = new FileReader();
        $('.preview').css('background-image', 'none');
        fr.onload = function() {
            $('.preview').css('background-image', 'url(' + fr.result + ')');
        }
        fr.readAsDataURL(file);
        $(".preview img").css('opacity', 0);
    }
);</script>
</body>

</html>