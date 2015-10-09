<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)){

if($_POST['name'] == ''){ 
  $error['name'] = 'blank';
  //var_dump($_POST);
}
if(strlen($_POST['password'])< 4 ){
  $error['password'] = 'length';
}
if(strlen($_POST['password'])> 8 ){
  $error['password'] = 'length';
}
if($_POST['password'] == ''){
  $error['password'] = 'blank';
}
if(strlen($_POST['message'])> 400 ){
  $error['message'] = 'length';
}
if($_POST['message'] == ''){
  $error['message'] = 'blank';
}

if(!empty($_POST)){
  
    $sql = sprintf('INSERT INTO posts SET name="%s",message="%s",password="%s",del_flg=0, create_date=NOW(),update_date=NOW()',
      mysqli_real_escape_string($db,$_POST['name']),
      mysqli_real_escape_string($db,$_POST['password']),//パスワードを記録する
      mysqli_real_escape_string($db,$_POST['message']));//返信機能を記録する
      mysqli_query($db,$sql) or die(mysqli_error($db));
      header('Location: index.php');
    exit();
  }
}

$sqls = 'SELECT * FROM posts WHERE del_flg=0';
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
          <input type="message" name="message" size="10" maxlength="400" />
          <?php if (isset($error['message'])): ?>
            <?php if ($error['message'] == 'lengh'): ?> 
            <p class="error">*記事は400文字以内で投稿して下さい</p> 
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
    <p><a href="delete.php?id=%d">[削除]</a></p>
    <p><a href="update.php?code=%d">[編集]</a></p>
  <?php endwhile ;?>




  </body>
</html>