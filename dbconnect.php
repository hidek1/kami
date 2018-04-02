<?php  $dsn = 'mysql:dbname=kami;host=localhost';
 // XAMPP環境下ではユーザー名rootパスワード空
 $user = 'root';
 $password = '';
 //このプログラムが存在している場所と同じサーバーを指定
 $dbh = new PDO($dsn,$user,$password);
 $dbh->query('SET NAMES utf8');
 ?>