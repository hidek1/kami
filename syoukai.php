<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>KAMI</title>
<link rel="stylesheet" href="syoukai.css">
<link rel="stylesheet" href="css/home_bootstrap.css">

</head>
<body>
<div class="container">
  <div class="row">
    <h1 style="text-align: center;">TEAM pelo</h1>
    <div class="hoge" style="  width:800px;
  height:500px; margin: 0 auto;
  background: url('images/preset.jpg') #fff; background-size:contain;"></div>
  </div>
 
 <div class="row">

  <a href="login.php"><button type="button" class="btn btn-primary center-block" style="">ログイン画面へ</button></a>
 </div>
</div>
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/jquery.ripples.js"></script>
  <script>
  $(function(){
  let $hoge = $('.hoge');
  $hoge.ripples({
    resolution: 400,
    dropRadius: 25,
    perturbance: 0.05
  });
});
</script>
</body>
</html>