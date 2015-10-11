<?php
session_start();
require('dbconnect.php');

function h($value){
  return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
}

if (!empty($_POST)){

if($_POST['name'] == ''){ 
  $error['name'] = 'blank';
}
if(strlen($_POST['message'])> 400 ){
  $error['message'] = 'length';
}
if($_POST['message'] == ''){
  $error['message'] = 'blank';
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

if($name == ''|| $password == ''||  $message == ''){
}
if(!empty($_POST)){
  
    $sql = sprintf('INSERT INTO posts SET name="%s",message="%s",password="%s",del_flg=0, create_date=NOW(),update_date=NOW()',
      mysqli_real_escape_string($db,$_POST['name']),
      mysqli_real_escape_string($db,$_POST['message']),//パスワードを記録する
      mysqli_real_escape_string($db,$_POST['password']));
      mysqli_query($db,$sql) or die(mysqli_error($db));
      header('Location: index.php');
    exit();
  }
}

$sqls = 'SELECT * FROM posts WHERE del_flg=0 ORDER BY id DESC';
$datas = mysqli_query($db,$sqls) or die(mysqli_error($db));

?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">

  <title>PHP基礎</title>

  </head>
  <body>

  <!--post送信で、ここで入力したデータを指定したページへ持っていく-->
    <form method = "post" action = "" ><!--飛び先を指定する-->
    <h1>投稿</h1>
    ニックネーム：必須</br>
    <dd>
          <?php if(!isset($name)){
          $name = '';
          }
          ?>
            <input type="text" name="name" size="35" maxlength="64" value = "<?php if(isset($_POST['name'])){echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8' );} ?>" />
              <?php if (isset($error['name'])): ?>
              <?php if ($error['name'] == 'blank') : ?> 
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

    記事：必須</br>

    <dd>
        <?php if(!isset($message)){
        $message = '';
        }
        ?>
        <textarea type="text" name="message" style="width:300px" maxlength="400" ></textarea>
        <?php if (isset($error['message'])): ?>
          <?php if ($error['message'] == ''): ?> 
          <p class="error">*記事を400文字以内で投稿して下さい</p> 
          <?php endif; ?>
        <?php endif; ?>
    </dd>
    
    </br>
    
    <!--submitボタンでデータを共に次のページへ持っていく-->
    <input type = "submit" value = "送信">
    </form>
  <h2>記事一覧</h2>
  <!-- 連想配列を取得します -->
  <?php while ($data = mysqli_fetch_array($datas)) :?>
    <p>ニックネーム：<?php echo $data['name'] ;?></p>
    <p>メッセージ：<?php echo $data['message'] ;?></p>
    <p>投稿日時：<?php echo $data['create_date'] ;?></p>
    <p>編集日時：<?php echo $data['update_date'] ;?></p>
    <a href="delete.php?id=<?php echo h($data['id'])?>">[削除]</a>
    <a href="update.php?id=<?php echo h($data['id'])?>">[編集]</a>
    <a href="ichiran.php?id=<?php echo h($data['id'])?>">[詳細]</a>
    
  <?php endwhile ;?>




  </body>
</html>