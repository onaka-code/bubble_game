<?php
require_once("dbfunc.php");

if(isset($_GET['theScore'])){
  $theScore = (int)$_GET['theScore'];
}else{
  exit('スコアを登録できません！');
}
setScore($theScore);

$ranking = getRank();
$top_keyindex = array_search(1, array_column($ranking, 'rank'));
$top = $ranking[$top_keyindex];

$top2_keyindex = array_search(2, array_column($ranking, 'rank'));
$top2 = $ranking[$top2_keyindex];

$top3_keyindex = array_search(3, array_column($ranking, 'rank'));
$top3 = $ranking[$top3_keyindex];



?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ゲームは終了です</title>
</head>
<body>
  <div class = "ranking">
    <table>
      <thead>
        <tr>
          <th colspan = "3">TOP3ランキング</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $top["rank"]?></td>
          <td><?php echo setName($top["name"])?></td>
          <td><?php echo $top["score"]?></td>
        </tr>
        <tr>
          <td><?php echo $top2["rank"]?></td>
          <td><?php echo setName($top2["name"])?></td>
          <td><?php echo $top2["score"]?></td>
        </tr>
        <tr>
          <td><?php echo $top3["rank"]?></td>
          <td><?php echo setName($top3["name"])?></td>
          <td><?php echo $top3["score"]?></td>
        </tr>
        
        
      </tbody>
    </table>
  </div>
  <div class = "result">
    <p>あなたの点数：</p>
    <p id = "score"></p>
  </div>

  <form action = "http://localhost:8888/game/farewellPage.php" method = "post">
    <p>名前を入力します</p>
    <p>※しない場合でもスコアは保存されます</p>
    <input type ="text" value = "ゲスト" name = "name">
    <input type = "submit" value = "登録">
  </form>


  <script>
    // データの受取
    const query = location.search;
    const value = query.split('=');
    // スコア表示
    const playersScore = document.getElementById('score');
    playersScore.textContent = decodeURIComponent(value[1]);
  </script>

  <style>
    .ranking{
      align:center;
    }
    thead{
      border:0.1em solid black;
    }
    table{
      border:0.2em solid black;
      text-align:center;
      margin-left:auto;
      margin-right:auto;
    }


    tr{
      border:0.1em solid black;
    }

    .result{
      text-align:center;
    }

    form{
      text-align:center;
    }
  </style>

</body>
</html>