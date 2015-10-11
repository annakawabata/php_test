<?php
    //編集時に必要な情報
session_start();
require('dbconnect.php');

//編集時に必要な情報
  //$tableの中に posts　の情報を全部入れている
if(isset($_REQUEST['id'])){
$sql = sprintf('SELECT * FROM posts WHERE id=%d',
	mysqli_real_escape_string($db,$_REQUEST['id']));
$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$table = mysqli_fetch_array($record);
}

//編集後保存させる
if(!empty($_POST)){
//var_dump($_POST);
if($_POST['message'] != ''){ //アスタリスクいらない
	$sql = sprintf('UPDATE posts SET message="%s" WHERE id=%d',
		mysqli_real_escape_string($db,$_POST['message']),
		mysqli_real_escape_string($db,$_GET['id']));

		mysqli_query($db,$sql) or die(mysqli_error($db));

		//これすることによって再読込ボタンを押したことによる、二重投稿を防止している。
		header('Location:index.php');
		exit();
}
}
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">

  <title>PHP基礎</title>

  </head>
  <body>
  <form method = "post">
  <!--<?php if(isset($_REQUEST['id'])){print $table['name'].'様';}?>
  これはid(id)をリクエストしてその中のデータをプリントしている-->
  ニックネーム:<?php if(isset($_REQUEST['id'])){print $table['name'].'様';}?></br>
  投稿を編集してください:</br>
  <input name = "message" type = "text" style = "width:300px" value="<?php if(isset($_REQUEST['id'])){print $table['message'];}?>">
  
  </br>
  
  <!--submitボタンでデータを共に次のページへ持っていく-->
  <input type = "submit" value = "保存">
  <input type = "button" onclick = "history.back()" value = "戻る">
  </form>

  </body>
</html>