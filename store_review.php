<?php

require('dbconnect.php');
session_start();


if (!empty($_POST)) {

// お店の名前が入ってないとき
if ($_POST['store_name_abc'] == '') {
  $error['store_name_abc'] == 'blank';
}
// お店の名前が入ってないとき
 if ($_POST['store_name'] == '') {
  $error['store_name'] = 'blank';
}

// 登録するstoreのduplicate cheak!!if (!isset($error)) {

  $sql = 'SELECT COUNT(*) AS `name_count` FROM `kami_shops` WHERE `shop_name_abc`=?';
  $data = array($_POST['store_name_abc']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $name_count = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($name_count['name_count'] >=1) {
    $error['store_name_abc'] = 'duplicated';
 }
}


    if (!isset($error)) {

$ext = substr($_FILES['picture']['name'],-3);
  $ext = strtolower($ext);


if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
$shop_pic = date('YmdHis') . $_FILES['picture']['name'];
move_uploaded_file($_FILES['picture']['tmp_name'], 'shop_pic/'.$shop_pic);

// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// exit;

  $shop_name_abc = htmlspecialchars($_POST['store_name_abc']);
  $shop_name = htmlspecialchars($_POST['store_name']);
  $shop_type = htmlspecialchars($_POST['category']);


  $sql = 'INSERT INTO `kami_shops` SET `shop_name_abc`=? , `shop_name` =? , `shop_pic` = ? , `shop_type`=? , `created`=NOW() , `modified`=NOW()';

$date = array($shop_name_abc,$shop_name,$shop_pic,$shop_type);
$stmt = $dbh->prepare($sql);
$stmt->execute($date);


header('Location: store_details.php?name='.$shop_name);
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
  <title>store_review</title>
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
               <li class="current"><a href="store_review.php" title="">お店を投稿する</a></li>

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
   <section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">

        <section>

          <div class="primary-content">

            <h1 class="entry-title add-bottom">お店投稿</h1>

            <p class="lead">新しいお店を投稿しよう！！</p> 

            <form name="cForm" id="cForm" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
                 <fieldset>
                       <div><h1>店名</h1></div><?php if (isset($error['store_name_abc']) && $error['store_name_abc'] == 'duplicated') { ?>
                        <P class="error"><font color="red">そのお店...既にありますから〜〜</font></P>
                     <?php } ?>
                       <div class="form-field">
                      <input name="store_name_abc" type="text" id="cName" class="full-width" placeholder="アルファベット" value="">
                      <?php if (isset($error['store_name_abc']) && $error['store_name_abc'] == 'blank') { ?>
                    <p class="error"><font color="red">なんか入れてよ！</p>
                     <?php } ?>
                      <input name="store_name" type="text" id="cName" class="full-width" placeholder="カタカナ" value="">
                     <?php if (isset($error['store_name']) && $error['store_name'] == 'blank') { ?>
                    <p class="error"><font color="red">なんか入れてよ！</p>
                     <?php } ?>
                       </div>

                       <br>
                       <br>
                       <br>

                       <div><h1>ジャンル</h1>
                        <select name="category">
                         <option value="未選択">選択してください</option>
                          <option value="比国">比国🍔</option>
                           <option value="韓国">韓国🍺</option>
                            <option value="中華">中華🍜</option>
                             <option value="和食">和食🍙</option>
                              <option value="洋食">洋食🍕</option>
                        </select>
                       </div>
                        <br>
                         <br>
                          <br>

                      <!-- 写真 -->
                      <h1>写真</h1>
                       <p class="btn_upload">画像ファイルを選択してアップロード</p>
                      <div class="input_file" style="width: 80%;height: 320px;">
                        <div class="preview" style="width: 250px;height: 250px; background-size: cover; background-position:50% 50%;">
                         <input accept="image/*" id="imgFile" type="file" name="picture">
                        </div>
                       </div>



                      <!-- <div class="add_files"><h1>写真（外観１枚）</h1>
                       <div class="preview"><input id="fileupload_file" type="file" name="picture" accept="image/*"></div>
                      </div> -->

                      <br>
                       <br>
                        <br>

                      <!-- 地図 -->
                      <div><h1>地図</h1></div>

                      <input name="cName" type="text" id="cName" class="full-width" placeholder="URL" value="">

                       <div id="map">
                <!-- GOOGLE MAP -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3040.547781743547!2d135.5327529620982!3d34.668715407946024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e0a5fec70de9%3A0xce2186a34bce6a21!2z5pel5pys44CB44CSNTM3LTAwMjQg5aSn6Ziq5bqc5aSn6Ziq5biC5p2x5oiQ5Yy65p2x5bCP5qmL77yS5LiB55uu77yV4oiS77yR77yV!5e0!3m2!1sja!2sph!4v1518861148520" width="800" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                <!-- // GOOGLE MAP -->
              </div>

              <br>
              <br>
              <br>

                       <button type="submit" class="submit button-primary full-width-on-mobile">投稿する</button>

                 </fieldset>
                </form> <!-- end form -->

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
