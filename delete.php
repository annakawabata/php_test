<?php

$db = mysqli_connect('localhost', 'root', 'root', 'php_test') or die(mysqli_connect_error());
mysqli_set_charset($db, 'utf8');


$sql = sprintf('UPDATE posts SET del_flg=1 WHERE id=%d' , $_REQUEST['id']);
mysqli_query($db,$sql);
header('Location: index.php');
?>