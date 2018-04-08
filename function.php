<?php
  session_start();

  // 関数とは、一定の処理をまとめて名前をつけて置いてるプログラムの塊
  // 何度も同じ処理を行う時に便利

  // ログインチェックの関数定義
  function login_check() {
    // require('dbconnect.php');

    // 1時間ログインしていない場合、再度ログイン
    if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
      // ログインしている
      // ログイン時間の更新
      $_SESSION['time'] = time();

      // ログインユーザー情報取得
      // $login_sql = 'SELECT * FROM `members` WHERE `member_id`=?';
      // $login_data = array($_SESSION['id']);
      // $login_stmt = $dbh->prepare($login_sql);
      // $login_stmt->execute($login_data);
      // global $login_member;
      // $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);

    } else {
      // ログインしていない、または時間切れの場合
      header('Location: login.php');
      exit;
    }
  }
?>