<?php

require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');

$sql = 'SELECT * FROM `kami_shops` WHERE `shop_name`=?';
$data = array($_GET['name']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$store_infoo = $stmt->fetch(PDO::FETCH_ASSOC);


if (!empty($_POST)) {

// お店の名前が入ってないとき
  if ($_POST['store_name_abc'] == '') {
    $error['store_name_abc'] = 'blank';
}

if ($_POST['store_name'] == '') {
  $error['store_name'] = 'blank';
}

// 重複チェック
$sql = 'SELECT COUNT(*) AS `name_count` FROM `kami_shops` WHERE `shop_name_abc`=?';
  $data = array($_POST['store_name_abc']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $name_count = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($name_count['name_count'] >=1) {
    $error['store_name_abc'] = 'duplicated';
 }


if (!isset($error)) {


$ext = substr($_FILES['picture_edit']['name'],-3);
  $ext = strtolower($ext);


if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
$shop_pic = date('YmdHis') . $_FILES['picture_edit']['name'];
move_uploaded_file($_FILES['picture_edit']['tmp_name'], 'shop_pic/'.$shop_pic);


 $shop_name_abc = htmlspecialchars($_POST['store_name_abc']);
  $shop_name = htmlspecialchars($_POST['store_name']);
  $shop_type = htmlspecialchars($_POST['category']);


$sql = 'UPDATE `kami_shops` SET `shop_name_abc`=?,`shop_name`=?,`shop_pic`=?,`shop_type`=?,`modified`=NOW() WHERE `shop_name`=?';
$data = array($shop_name_abc , $shop_name , $shop_pic , $shop_type , $_GET['name']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header('Location:store_details.php?name=' . $shop_name);
exit();

}else{

header('Location:store_review_edit.php');
exit();
}
}
}

 ?>



<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="utf-8">
  <title>お店投稿</title>
  <meta name="description" content="">
  <meta name="author" content="">

   <!-- mobile specific metas
   ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/base.css">
   <link rel="stylesheet" href="css/vendor.css">
   <link rel="stylesheet" href="css/main.css">

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
  


<?php 
require('header.php');
?>

   <!-- content
   ================================================== -->
   <section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">

        <section>


          <div class="primary-content">

            <h1 class="entry-title add-bottom">お店編集</h1>

            <p class="lead">お店情報を編集しよう。</p>


            <form name="cForm" id="cForm" method="post" action="" enctype="multipart/form-data">
                 <fieldset>
                       <div>
                        <h1>
                          <?php echo $store_infoo['shop_name_abc'] ; ?>
                        </h1>
                       </div>
                       <div class="form-field">
                        <input name="store_name_abc" type="text" id="cName" class="full-width" placeholder="アルファベット" value="">
                        <?php if (isset($error['store_name_abc']) && $error['store_name_abc'] == 'blank') { ?>
                         <P class="error"><font color="red">入力をお忘れでは？？</font></P>
                        <?php } elseif (isset($error['store_name_abc']) && $error['store_name_abc'] == 'duplicated'){ ?>
                         <p class="error"><font color="red">そのお店...既にありますから〜〜</font></p>
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
                      <span class="retty-btn fileinput-button fileinput-button-mypage">
                      <div class="add_files"><h1>写真（外観１枚）</h1></div>
                       <input id="fileupload_file" type="file" name="picture_edit" multiple=""></span>

                      <br>
                      <br>
                      <br>
                      <div><h1>地図</h1></div>
                       <div id="map">
                <!-- GOOGLE MAP -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3040.547781743547!2d135.5327529620982!3d34.668715407946024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e0a5fec70de9%3A0xce2186a34bce6a21!2z5pel5pys44CB44CSNTM3LTAwMjQg5aSn6Ziq5bqc5aSn6Ziq5biC5p2x5oiQ5Yy65p2x5bCP5qmL77yS5LiB55uu77yV4oiS77yR77yV!5e0!3m2!1sja!2sph!4v1518861148520" width="800" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                <!-- // GOOGLE MAP -->
              </div>
               <br>
                <br>
                 <br>
                  <button type="submit" class="submit button-primary full-width-on-mobile">編集完了</button>
                   </fieldset>
                    </form> <!-- end form -->
                   </section>
                  </div> <!-- end col-twelve -->
                 </div> <!-- end row -->
                </section> <!-- end content -->
<!-- footer
   ================================================== -->
   <footer>

                  <p class="keigo"><span>© kami 2018</span>
                  <span>by team pelo</a></span></p>

                <!-- end footer-bottom -->
   </footer>

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="http://maps.google.com/maps/api/js?v=3.13&amp;sensor=false"></script>
   <script src="js/main.js"></script>  
   <script src="js/modal.js"></script>
</body>

</html>