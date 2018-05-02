<?php
require('function.php');
  login_check();

require('dbconnect.php');
require('tsuuti.php');

if (!empty($_POST)) {

// お店の名前が入ってないとき
if ($_POST['store_name_abc'] == '') {
  $error['store_name_abc'] = 'blank';
}
// お店の名前が入ってないとき
 if ($_POST['store_name'] == '') {
  $error['store_name'] = 'blank';
}

// 登録するstoreのduplicate cheak!!
if (!isset($error)) {

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

echo '<pre>';
var_dump($_POST);
echo '</pre>';
// exit;

  $shop_name_abc = htmlspecialchars($_POST['store_name_abc']);
  $shop_name = htmlspecialchars($_POST['store_name']);
  $shop_type = htmlspecialchars($_POST['category']);


  $sql = 'INSERT INTO `kami_shops` SET `shop_name_abc`=? , `shop_name` =? , `shop_pic` = ? , `shop_type`=? , `created`=NOW() , `modified`=NOW(), `lat`=? , `lng`=? ';

$date = array($shop_name_abc,$shop_name,$shop_pic,$shop_type,$_POST['lat'],$_POST['lng']);
$stmt = $dbh->prepare($sql);
$stmt->execute($date);
var_dump($_POST);

header('Location: store_details.php?name='.$shop_name);
exit();

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
  <style>
    #map{
      width: 850px;
      height: 400px;
    }
  </style>

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

            <h1 class="entry-title add-bottom">お店投稿</h1>

            <p class="lead">新しいお店を投稿しよう！！</p>

            <form name="cForm" id="cForm" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                 <fieldset>
                       <div><h1>店名</h1></div>
                       <div class="form-field">
                      <input name="store_name_abc" type="text" id="cName" class="full-width" placeholder="アルファベット" value="">
                      <?php if (isset($error['store_name_abc']) && $error['store_name_abc'] == 'blank') { ?>
                      <p class="error"><font color="red">なんか入れてよ！</p>
                      <?php } elseif (isset($error['store_name_abc']) && $error['store_name_abc'] == 'duplicated') { ?><P class="error"><font color="red">そのお店...既にありますから〜〜</font></P>
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
                       <div class="view_box">

                            <input type="file" class="file" name="picture">
                       </div>


<!-- 地図 -->
                  <div class="map">
                    <h1>地図</h1>
                  <div id="map">
                  </div>
                    <input type="hidden" name="lat" id="lat"><br>
                    <input type="hidden" name="lng" id="lng"><br>
                  </div>

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
   <div id="preloader"> 
      <div id="loader"></div>
   </div> 

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpUu08GcFO2jItVjyR9lxweWq7lKiRgWc&callback=initMap"></script> 
    <script>
      function initMap() {
        // マップの初期化
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: {lat: 10.329092, lng: 123.903811}
        });
        var countElement = document.getElementById( "count" ) ;
        // クリックイベントを追加
        map.addListener('click', function(e) {
          getClickLatLng(e.latLng, map);
        });
      }
      function getClickLatLng(lat_lng, map) {
        // 座標を表示
        document.getElementById('lat').value = lat_lng.lat();
        document.getElementById('lng').value = lat_lng.lng();
        // マーカーを設置
        var marker = new google.maps.Marker({
          position: lat_lng,
          map: map
        });
        // 座標の中心をずらす
        map.panTo(lat_lng);
      }
   </script>
   <script src="js/main.js"></script>
   <script src="js/modal.js"></script>

  <!--  <script>$('#imgFile').change(
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
   );</script> -->

   <script>
     $(document).ready(function () {
  $(".file").on('change', function(){
     var fileprop = $(this).prop('files')[0],
         find_img = $(this).parent().find('img'),
         filereader = new FileReader(),
         view_box = $(this).parent('.view_box');

    if(find_img.length){
       find_img.nextAll().remove();
       find_img.remove();
    }

    var img = '<div class="img_view"><img alt="" class="img"><p><a href="#" class="img_del">画像を削除する</a></p></div>';

    view_box.append(img);

    filereader.onload = function() {
      view_box.find('img').attr('src', filereader.result);
      img_del(view_box);
    }
    filereader.readAsDataURL(fileprop);
  });
  function img_del(target){
    target.find("a.img_del").on('click',function(){
      var self = $(this),
          parentBox = self.parent().parent().parent();
      if(window.confirm('画像を削除します。\nよろしいですか？')){
        setTimeout(function(){
          parentBox.find('input[type=file]').val('');
          parentBox.find('.img_view').remove();
        } , 0);
      }
      return false;
    });
  }

});
</script>

</body>

</html>
