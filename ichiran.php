<?php
session_start();
require('dbconnect.php');

function h($value){
  return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
}

$name = $_POST['name'];
$message = $_POST['message'];

$comment_name = $_POST['comment_name'];
$comment = $_POST['comment'];

if (!empty($_POST)){

if($_POST['comment_name'] == ''){ 
  $error['comment_name'] = 'blank';
}
if(strlen($_POST['comment'])> 100 ){
  $error['comment'] = 'length';
}
if($_POST['comment'] == ''){
  $error['comment'] = 'blank';
}
// if(strlen($_POST['password'])< 4 ){
//   $error['password'] = 'length';
// }
// if(strlen($_POST['password'])> 8 ){
//   $error['password'] = 'length';
// }
if(mb_strlen($password) < 4) {

  $regist_error .= "パスワードは4文字以上で設定してください<br />";
  } elseif (mb_strlen($password) > 8) {
  $regist_error .= "パスワードが長すぎます。8文字以下で設定してください。<br />";

}
if (!preg_match( "/[\@-\~]/" , $password)) {

$regist_error .= "パスワードは半角英数字及び記号のみ入力してください。<br />";

}
if($_POST['password'] == ''){
  $error['password'] = 'blank';
}

if($comment_name == ''|| $password == ''||  $comment == ''){
}
if(!empty($_POST)){
  
$sql = sprintf('INSERT INTO `akawabata_db`.`comments` (`id`, `post_id`, `comment_name`, `password`, `comment`, `reply_post_id`, `del_flg`, `create_date`, `update_date`) VALUES (post_id="%d",comment_name="%s",password="%s",comment="%s",del_flg=0, create_date=NOW(),update_date=NOW()');

	if('id' == 'post_id')
      // mysqli_real_escape_string($db,$_POST['comment_name']),
      // mysqli_real_escape_string($db,$_POST['comment']),//パスワードを記録する
      // mysqli_real_escape_string($db,$_POST['password']));
      mysqli_query($db,$sql) or die(mysqli_error($db));
      header('Location: index.php');
    exit();
  }
}

$sqls = 'SELECT * FROM comments WHERE del_flg=0 ORDER BY id DESC';
$datas = mysqli_query($db,$sqls) or die(mysqli_error($db));

if(isset($_REQUEST['id'])){
$sql = sprintf('SELECT * FROM posts WHERE id=%d ORDER BY id DESC',
mysqli_real_escape_string($db,$_REQUEST['id']));
$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$table = mysqli_fetch_array($record);
}
// $sql = sprintf('SELECT * posts WHERE id=$_REQUEST['id']' , $_REQUEST['code']);
// mysqli_query($db,$sql);
// header('Location: ichiran.php');

//$sqls = 'SELECT * FROM posts WHERE id=$_REQUEST['id']';
//$datas = mysqli_query($db,$sqls) or die(mysqli_error($db));
?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">

  <title>記事詳細</title>

  </head>
  <body>

  <!--post送信で、ここで入力したデータを指定したページへ持っていく-->
    <form method = "post" action = "" ><!--飛び先を指定する-->
    <h1>詳細ページ</h1>
    <h2><?php while ($data = mysqli_fetch_array($datas)) :?>
    <p><?php echo $data['comment_name'] ;?></p>
    <p><?php echo $data['comment'] ;?></p></h2>
    <p>投稿日時：<?php echo $data['create_date'] ;?></p>
    <p>編集日時：<?php echo $data['update_date'] ;?></p>
  
    <?php endwhile ;?>
<!--/////////////////////////////////////////////////-->
  <h4>コメント入力欄</h4>
    ニックネーム：必須</br>
    <dd>
          <?php if(!isset($name)){
          $name = '';
          }
          ?>
            <input type="text" name="name" size="35" maxlength="64" value = "<?php if(isset($_POST['comment_name'])){echo h($_POST['comment_name'], ENT_QUOTES, 'UTF-8' );} ?>" />
              <?php if (isset($error['comment_name'])): ?>
              <?php if ($error['comment_name'] == 'blank') : ?> 
              <p class="error">*ニックネームを入力して下さい</p>
              <?php endif; ?>
            <?php endif; ?>
    </dd>

    パスワード：必須</br>

    <dd>
          <?php if(!isset($password)){
          $password = '';
          }
          ?>
            <input type="password" name="password" size="10" maxlength="8" />
            <?php if (isset($_POST['password'])): ?>
              <?php if ($error['password'] == 'blank'): ?> 
              <p class="error">*パスワードを入力して下さい</p> 
              <?php endif; ?>
              <?php if ($error['password'] == 'length'): ?>
              <p class="error" >*パスワードは４文字以上で入力して下さい</p> 
              <?php endif; ?>
            <?php endif; ?>
    </dd>

    コメント：必須</br>

    <dd>
          <?php if(!isset($comment)){
          $comment = '';
          }
          ?>
          <textarea type="text" name="comment" style="width:300px" maxlength="100"></textarea>
          <?php if (isset($error['comment'])): ?>
            <?php if ($error['comment'] == ''): ?> 
            <p class="error">*コメントは100文字以内で投稿して下さい</p> 
            <?php endif; ?>
          <?php endif; ?>
    </dd>
    
    </br>
    
    <!--submitボタンでデータを共に次のページへ持っていく-->
    <input type = "submit" value = "コメントする">
    </form>
  </body>
</html>