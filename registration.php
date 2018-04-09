<?php
session_start();
require('dbconnect.php');


if (!empty($_POST) && isset($_POST)) {

  if ($_POST['nickname']=='') {
   $error['nickname']='blank';
  }

  if ($_POST['room_number']=='') {
   $error['room_number']='blank';
  }
  if($_POST['email']=='') {
   $error['email']='blank';
  }

  if ($_POST['password'] == '') {
      $error['password'] = 'blank';
    } elseif(strlen($_POST['password']) < 4) {
      $error['password'] = 'length';
    }

  if ($_POST['stay_start']=='') {
   $error['stay_start']='blank';
  }

  if ($_POST['stay_finish']=='') {
   $error['stay_finish']='blank';
  }
 // $_SESSION['join']=$_POST;

  // if ($_POST['password1']!==$_POST['password2']) {
  //   $error['password']='not_same';
  // }

  if (!isset($error)) {
    $sql='SELECT COUNT(*) AS `identified` FROM `kami_members` WHERE `email`=?';
    $data = array($_POST['email']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $identified = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($identified);

    if ($identified['identified'] >= 1) {
      $error['email']='duplicated';
    }
  
  // echo '<pre>';
  // echo "<br>";
  //   echo "<br>";

  //         var_dump($_POST);
  //         echo '</pre>';
  //         exit();
  
  if (!isset($error)) {
     $_SESSION['join']=$_POST;
     $_SESSION['join']['picture_path'];
    if (isset($_FILES["picture_path"]["error"])) {
     header('Location: check.php');
    exit();
  }else{
    $ext=substr($_FILES['picture_path']['name'], -3);
    $ext=strtolower($ext);
    if ($ext=='jpg' || $ext=='png') {
    $picture_path=date('YmdHis').$_FILES['picture_path']['name'];
    // var_dump($_FILES['picture_path']['tmp_name']);

// permissionと絶対パス
 move_uploaded_file($_FILES['picture_path']['tmp_name'], 'picture_path/'.$picture_path);

  $_SESSION['join']=$_POST;
  // var_dump($_SESSION);
  $_SESSION['join']['picture_path']=$picture_path;
// var_dump($_SESSION);
    header('Location: check.php');
    exit();
    } else {
    $error['picture_path']='type';
      }
    }
  }
 }
}


 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>新規会員登録</title>

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
      <ul class="main-navigation sf-menu">
         <li><button type="" class="button-primary">新規会員登録</button></li>
         <li>→</li>
         <li>登録内容確認</li>
         <li>→</li>
         <li>登録完了</li>
         <li>→</li>
         <li>ログイン</li>
      </ul>
   </nav> <!-- end main-nav-wrap -->
   </header> <!-- end header -->

<section id="content-wrap" class="site-page">
    <div class="row">
      <div class="col-twelve">
      <section>
         <div class="primary-content">
            <h3 class="entry-title">新規会員登録</h3>
            <p class="lead">会員登録お願いいたします！</p>
         </div>
   <form name="" id="cForm" method="post" action="" enctype="multipart/form-data">
   <fieldset>
   <h3>ニックネーム</h3>
     <div class="form-field">
      <input name="nickname" type="text" id="cName" class="full-width" placeholder="kami" value="">
      <?php if (isset($error['nickname'])) {
          if ($error['nickname']=='blank') { ?>
           <p class="error" style="color: red;">*ニックネームを入力してください</p>
        <?php  }
          // if ($error['nickname']=='duplicated') {
          // echo'*そのニックネームはすでに使われています';
          // }
      } ?>
        </div>

        <h3>メールアドレス</h3>
     <div class="form-field">
       <input name="email" type="email" id="cName" class="full-width" placeholder="" value="">
<?php if (isset($error['email']) && $error['email'] == 'blank') { ?>
              <p class="error" style="color: red;">* メールアドレスを入力してください。</p>
              <?php } elseif(isset($error['email']) && $error['email'] == 'duplicated') { ?>
              <p class="error" style="color: red;">* 入力されたメールアドレスは登録済みです。</p>
              <?php } 

      ?>
     </div>

   <h3>パスワード</h3>
     <div class="form-field">
       <input name="password" type="password" id="cName" class="full-width" placeholder="" value="">
       <?php if (isset($error['password']) && $error['password'] == 'blank') { ?>
              <p class="error" style="color: red;">* パスワードを入力してください。</p>
              <?php } elseif(isset($error['password']) && $error['password'] == 'length') { ?>
              <p class="error" style="color: red;">* パスワードは4文字以上入力してください。</p>
              <?php } ?>
     </div>



  <!-- <h3>パスワード（確認）</h3>
     <div class="form-field">
       <input name="password2" type="password" id="cName" class="full-width" placeholder="" value=""> -->

     <!-- </div> -->

   <h3>部屋番号</h3>
     <div class="form-field">
       <input name="room_number" type="text" id="cName" class="full-width" placeholder="200A" value="">
       <?php if (isset($error['room_number'])) {
          if ($error['room_number']=='blank') {
          ?>
         <p class="error" style="color: red;">*部屋番号を入力してください</p>
      <?php  }
     } ?>
     </div>

   <h3>滞在期間</h3>
     <div class="form-field">
  from
       <input name="stay_start" type="date" id="cName" class="half-width" value="">
  to
       <input name="stay_finish" type="date" id="cName" class="half-width" value="">
       <?php if (isset($error['stay_start']) || isset($error['stay_finish'])) {
       if ($error['stay_start']=='blank' || $error['stay_finish']=='blank') { ?>
         <p class="error" style="color: red;">*滞在期間を入力してください</p>
      <?php  }
     } ?>
     </div>

   <h3>プロフィール画像(＊任意)</h3>
     <div class="form-field">
       <span class="retty-btn fileinput-button fileinput-button-mypage">
         <div class="add_files"></div>
           <input id="" type="file" name="picture_path" multiple="">
       </span>
       <?php if (isset($error['picture_path']) && $error['picture_path']=='type') { ?>
         <p class="error" style="color: red;">*拡張子が対応しておりません</p>
      <?php } ?>
     </div>

<div>
  <button type="submit" name='submit' class="submit button-primary full-width-on-mobile">確認画面へ</button>
</div>



</fieldset>
</form>
</section>
</div>
</div>
</section>
</body>
</html>
