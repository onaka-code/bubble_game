<?php
  require_once("dbfunc.php");

  $name = $_POST["name"];
  $id = getLastId()[0]["Max(id)"];
  updateName($name, $id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ありがとうございました！</title>
</head>
<body>
  <h1>
    <?php echo htmlspecialchars($name, ENT_QUOTES)?>さん、また遊びに来てくださいね！
  </h1>
</body>
</html>