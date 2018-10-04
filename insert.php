<?php

if(
  !isset($_POST['name']) || $_POST['name']=="" ||
  !isset($_POST['mail']) || $_POST['mail']=="" ||
  !isset($_POST['sex']) || $_POST['sex']=="" ||
  !isset($_POST['anime']) || $_POST['anime']==""
){
  exit('ParamError');
}

$name = $_POST["name"];
$mail = $_POST["mail"];
$sex = $_POST["sex"];
$anime = $_POST['anime'];

// DB 接続します
include('functions.php');
$pdo = db_conn();

// try {
//   $pdo = new PDO('mysql:dbname=gs_f01_db06;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('dbError:'.$e->getMessage());
// }

$sql ="INSERT INTO anime_post(id,name,mail,sex,created_at) 
VALUES (null,:a1,:a2,:a3,sysdate())";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $mail, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $sex, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


$sql ="INSERT INTO posted_anime(post_id,anime_id) 
VALUES (:b1,:b2)";
$last_id = $pdo->lastInsertID('id');



foreach($anime as $value){
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':b1', $last_id, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':b2', $value, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();
}


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("location: index.php");

}

?>

