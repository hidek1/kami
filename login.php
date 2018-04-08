<?php
session_start();
require('dbconnect.php');


if (!empty($_POST)) {
  $sql= 'SELECT * FROM `kami_members` WHERE `email`=? AND `password`=?';
  $data=array($_POST['email'], sha1($_POST['password']));
  $stmt=$dbh->prepare($sql);
  $stmt->execute($data);
  $member=$stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($member);
    if ($member == false) {
      $error['login'] = 'failed';
    } else {
      $_SESSION['id'] = $member['member_id'];

      $_SESSION['time'] = time();


    if ($_POST['save'] == 'on') {
        // setcookie(保存したいカラム名、保存したい値、今の時間から保存したい時間まで : 秒数) = $_COOKIEに値をセットする
        setcookie('email', $_POST['email'], time()+60*60*24*14);
        setcookie('password', $_POST['password'], time()+60*60*24*14);
      }

header('Location: home.php');
exit();
}
}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>kami ログイン</title>

  <!-- Bootstrap -->
   <!--  <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
</head> -->

<!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/saeko_base.css">
   <link rel="stylesheet" href="css/vendor.css">
   <link rel="stylesheet" href="css/saeko_main.css">

   <!-- script
   ================================================== -->
  <script src="js/modernizr.js"></script>
  <script src="js/pace.min.js"></script>

   <!-- favicons
  ================================================== -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  </head>

<body>

<!-- header
   ================================================== -->
   <header class="short-header">
      <div class="gradient-block"></div>
      <div class="row header-content">
         <div class="logo">
            <a href="#">Author</a>
         </div>
</div>
<nav id="main-nav-wrap">

</nav> <!-- end main-nav-wrap -->
   </header> <!-- end header -->

<section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">
      <section>
         <!-- <div class="primary-content"> -->
            <!-- <h3 class="entry-title">ログイン</h3> -->
         <!-- </div> -->
   <form name="" id="cForm" method="post" action="">
   <fieldset>
  
<h3>メールアドレス</h3>
     <div class="form-field">
       <input name="email" type="email" id="cName" class="full-width" placeholder="ka@mi.com" value="">
     </div>

   <h3>パスワード</h3>
     <div class="form-field">
       <input name="password" type="password" id="cName" class="full-width" placeholder="" value="">
     </div>
<div class="form-group">
            <label class="col-sm-4 control-label">自動ログイン</label>
            <div class="col-sm-8">
              <input type="checkbox" name="save" value="on">オンにする
            </div>
          </div>


   <br>
<?php if(isset($error['login']) && $error['login'] == 'failed') { ?>
            <p class="error">* emailかパスワードが間違っています。</p>
          <?php } ?>

          <button type="" class="main-navigation button-primary" style="margin-top: 35px">ログイン</button>



</fieldset>
</form>
</section>
</div>
</div>
</section>
</body>
</html>