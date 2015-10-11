<?php
session_start();
require('dbconnect.php');

if(isset($_REQUEST['id'])){
 $sql = sprintf('SELECT * FROM posts WHERE id=%d',
  mysqli_real_escape_string($db,$_REQUEST['id']));
 $record = mysqli_query($db,$sql) or die(mysqli_error($db));
 $table = mysqli_fetch_array($record);
}

if(!empty($_POST)){
 if ($_POST['password'] == ''){
  $error['password'] = 'blank';
 }

 if(empty($error)){
 if(sha1($_POST['password']) == $table['password']){
  // $sql = sprintf('DELETE FROM posts WHERE id=%d',
  // mysqli_real_escape_string($db,$_GET['id']));
  // mysqli_query($db,$sql) or die(mysqli_error($db));

   //二重投稿を防止している。
   header('Location:index.php');
   exit();
 }else{
  $error['password'] = 'diference';
 }
 }
}


$sql = sprintf('UPDATE posts SET del_flg=1 WHERE id=%d' , $_REQUEST['id']);
mysqli_query($db,$sql);
header('Location: index.php');
?>