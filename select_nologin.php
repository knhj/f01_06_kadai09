<?php
//1.  DB接続します
session_start();
include('functions.php');
$pdo = db_conn();
// chk_ssid();

//２．データ登録SQL作成
$stmt = $pdo->prepare('select * from anime_post');
$status = $stmt->execute();

//３．データ表示
$header = '';
// $header .= '<a class="navbar-brand" href="index.php">データ登録（投稿画面）</a>';
// if($_SESSION['kanri_flg'] ==1){
  // $header .=  '<a class="navbar-brand" href="user_select.php">ユーザー一覧</a>';
// }
$header .=  '<p class="navbar-brand">投稿一覧画面</p>';


$view='';
if($status==false){
  errorMsg($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= '<a href="detail_nologin.php?id='.$result["id"].'">';  //更新ページへのaタグを作成
    $view .= $result['name'].'['.$result['created_at'].']';
    $view .= '</a>';
    // $view .= '　';
    // $view .= '<a href="delete.php?id='.$result["id"].'">';  //削除用aタグを作成
    // $view .= '［削除］';
    // $view .= '</a>';
    $view .= '</p>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>管理画面表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <?=$header?>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
  </div>
</div>
<!-- Main[End] -->

</body>
</html>
