<?php

session_start();
require('dbconnect.php');
// var_dump($_SESSION);
// exit();

if (!empty($_POST)) {
  if($_POST["check"]){
  $sql='INSERT INTO `kami_members` SET `nickname`=?, `email`=?, `room_number`=?, `password`=?,`stay_start`=?, `stay_finish`=?, `picture_path`=?, `created`=NOW(), `modified`=NOW()';
  $data=array($_SESSION['join']['nickname'], $_SESSION['join']['email'], $_SESSION['join']['room_number'], sha1($_SESSION['join']['password']), $_SESSION['join']['stay_start'], $_SESSION['join']['stay_finish'], $_SESSION['join']['picture_path']);
  $stmt=$dbh->prepare($sql);
  $stmt->execute($data);

  unset($_SESSION);

  header('Location: thanks.php');
  exit();
  }else{
  header('Location: registration.php');
  exit();
  }
}




  ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登録内容確認</title>

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
         <!-- <div class="col-md-2"> -->
           
         <!-- </div> -->
       <!-- <div class="col-md-10"></div> -->
      <!--  <div class="col-md-4 text-center">
        <h3 class="">登録内容確認</h3>
       </div> -->
</div>



         <nav id="main-nav-wrap">
           <ul class="main-navigation sf-menu">
              <li>新規会員登録</li>
              <li>→</li>
              <li><button type="" class="button-primary">登録内容確認</button></li>
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
            <h2 class="entry-title">登録内容確認</h2>
            <p class="lead">登録内容をもう一度確認してね！</p>
            </div>
                <form name="" id="cForm" method="post" action="">
                   <fieldset>
                    <h3>ニックネーム</h3>
                    <div class="form-field">
                      <input name="" type="text" id="cName" class="full-width" placeholder="kami" value="<?php echo $_SESSION['join']['nickname']?>">
                       </div>

                    <h3>メールアドレス</h3>
                    <div class="form-field">
                   <input name="cName" type="email" id="cName" class="full-width" placeholder="" value="<?php echo $_SESSION['join']['email'] ?>">
                     </div>

                       <h3>部屋番号</h3>
                       <div class="form-field">
                      <input name="cName" type="text" id="cName" class="full-width" placeholder="200A" value="<?php echo $_SESSION['join']['room_number']; ?>">
                       </div>

                       <h3>パスワード</h3>
                       <div class="form-field">
                      <input name="cName" type="password" id="cName" class="full-width" placeholder="" value="<?php echo $_SESSION['join']['password']; ?>">
                       </div>

                       <h3>滞在期間</h3>
                       <div class="form-field">
                        from
                      <input name="" type="date" id="cName" class="half-width" value="<?php echo $_SESSION['join']['stay_start']; ?>">
                      to
                      <input name="" type="date" id="cName" class="half-width" value="<?php echo $_SESSION['join']['stay_finish']; ?>">
                       </div>


                  <!-- <div class="text-center">プロフィール画像</div> -->
                  <h3>プロフィール画像</h3>
                  <div class="form-field"><img src="picture_path/<?php echo $_SESSION['join']['picture_path']; ?>" width="100" height="100"></div>
                

                       </fieldset>
<button type="submit" name="rewrite" class="submit  full-width-on-mobile">書き直す</button>
                       <!-- <input type="hidden" name="check" value="check"> -->
                       <button type="submit" name="check" value="check" class="submit button-primary full-width-on-mobile">会員登録</button>
                </form> <!-- end form -->

</section>
</div>
</div>
</section>

</body>
</html>