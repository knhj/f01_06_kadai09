<?php
// getで送信されたidを取得
$id = $_GET['id'];
// echo "GET:".$id;

session_start();
include('functions.php');
$pdo = db_conn();
// chk_ssid();

//２．データ登録SQL作成，指定したidのみ表示する
$stmt = $pdo->prepare('select * from anime_post where id=:id');
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false){
  // エラーのとき
  errorMsg($stmt);
}else{
  // エラーでないとき
  $rs = $stmt->fetch();

  $stmt2 = $pdo->prepare('select selectedanime.title,selectedanime.year from selectedanime join posted_anime on posted_anime.anime_id = selectedanime.animeID where posted_anime.post_id = :id');
  $stmt2->bindValue(':id',$id, PDO::PARAM_INT);
  $status2 = $stmt2->execute();

  $titles = array();
  $years = array();
  $view="";
	while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

	$view .= '<li class="anititle">';
	$view .= $result2['title'];
	$view .= '（';
	$view .= $result2['year'];
	$view .= '）';
	$view .= '</li>';

	// $titles[] = $result2['title'];
	// $years[] = $result2['year'];
	//  var_dump($result2);
	}

//  var_dump($rs);
//  echo "<br>";
//   var_dump($titles);

  //$rs -> id | name  | mail  | sex | created_at |
  //$titles ->array(選んだアニメ) 
}

//２．データ登録SQL作成
// $stmt3 = $pdo->prepare("select * from selectedanime ");
// $status3 = $stmt3->execute();

//３．データ表示



?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
		 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>アニメアンケート編集画面</title>
		<style>
		body{
	        font-family: Roboto, "Yu Gothic Medium", "游ゴシック Medium", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", "メイリオ", sans-serif;
	        line-height: 1.75;
        	font-size: 16px;
        }
		*{
			list-style:none;
		}
		.flex{
			display:flex;
			justify-content:center;
			width:960px;
		}
		.cell1 {
			width:150px;
			text-align:left;
            height:30px;
			line-height: 30px;
			margin: 10px;
		}
		.cell2 {
			width:400px;
			text-align:left;
            height:30px;
			line-height: 30px;
			margin: 10px;
			
		}
		.bo{
			border: 2px gray solid;
			width:300px;
			border-radius: 6px;	
		}
		.checktitle{
        font-size: 20px;
        margin: 5px;
		border-bottom: 2px gray solid;
        width: 960px;
        margin: 0 auto 25px auto;
		}
		.btn {
			margin: 0 auto;
		}
		.anititle{
			width :960px;
			text-align:center;
		}
		.cent{
			display:flex;
			justify-content:center;
		}
		.year2015,.year2016,.year2017{
			display:none;
		}
		.anititle{
			background-color: #f0ebe5;
			line-height:30px;
			height:30px;
			width:680px;
			text-align:left;
			margin: 3px auto;
			border-radius: 6px;	
			/* border: 2px solid black; */
		}
		.btn {
			margin-bottom:3px;
		}
		</style>
	</head>
	<body style="padding: 50px;">
	 <div class="navbar-header"><a class="navbar-brand" href="select_nologin.php">投稿データ一覧</a></div>
	<h1 class="text-center bg-primary text-light font-weight-bold display-4">好きなアニメアンケート</h1>
		
			<ul >
				<li class="flex">
				    <div class="cell1">名前:</div>
					 <div class="cell2"><?= $rs["name"]?></div>
				</li>
				<li class="flex">
			    	<div class="cell1">EMAIL:</div> 
				    <div class="cell2"><?= $rs["mail"]?></div>
				</li>
				<li class="flex">
			    	<div class="cell1">性別:</div>
					<div class="cell2"> <?php if ($rs["sex"]=="man" ){echo "男";} if ($rs["sex"]=="woman" ){echo "女";}?>
					</div>
				</li>
				<li class="checktitle">選択されたタイトル（放送開始年）</li>
				
    			<?=$view?>

			</ul>
		
		
		

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 
 </body>

</html>



