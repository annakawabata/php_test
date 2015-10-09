<?php
session_start();
require('dbconnect.php');


?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">

  <title>確認画面</title>

  
  </head>
  <body>
    <h1>確認画面</h1>
    <!--post送信されたデータをここでも使用できるように$_POSTで取得する
        $nicknameという変数名をつけて 'nickname'のデータを取ってくる-->
    <?php
    $name = $_POST['name'];
    $password = $_POST['password'];
    $message = $_POST['message'];

    //htmlspecialchars
    //いたずらをされないよにデータを消毒する
    //他から入力されたHTMLを効かないようにする、怪しい文字を無毒化すること
    $name = htmlspecialchars($name);
    $password = htmlspecialchars($password);
    $message = htmlspecialchars($message);


    //内容に空欄がないかチェックする
    //内容が空だったら　と　入ってたら　の場合をif文で書く
    if($name == ''){
    	print'ニックネームが入力されていません。';
    }else{
    	print $name;
    	print '様';
    	print'</br>';
    }

    if($password == ''){
        print'パスワードが入力されていません。';
    }else{
        print'パスワード[';
        print $password;
        print']</br>';
    }

    if($message == ''){
    	print'記事が入力されていません。';
    }else{
    	print'投稿内容[';
    	print $message;
    	print']</br>';
    }

    if($name == ''|| $password == ''|| $message == ''){
        print '<form>';

        //onclick = "history.back()これはJavaScriptを利用しており、便利な機能
        //PHPでこの機能を書こうとすると難しいからよく使われている機能
        print '<input type = "button" onclick = "history.back()" value = "戻る">';
        print '</form>';
    }else{

        //さっきと同じようにpost送信でデータを指定したページへ運んでいる
        //postは郵便屋さんと同じような役割
        print '<form method = "post" action = "index.php">';
        //hiddenにすることで画面に表示されることなく、飛び先に飛ばす
        print '<input name = "name" type = "hidden" value = "'.$name.'">';
        // . ドットで文字と文字を連結している
        print '<input name = "password" type = "hidden" value = "'.$password.'">';
        print '<input name = "message" type = "hidden" value = "'.$message.'">';
        print '<input type = "button" onclick = "history.back()" value = "戻る">';
        print '<input type = "submit" value = "投稿">';
        print '</form>';

    $sql = 'INSERT INTO posts(name,password,message)VALUES("'.$name.'","'.$password.'","'.$message.'")';
    mysqli_query($db, $sql) or die(mysqli_error($db));
    exit();
    }
    ?>

  </body>
</html>