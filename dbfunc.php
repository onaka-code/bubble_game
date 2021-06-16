<?php

function dbConnect(){
  $dsn = 'mysql:host=127.0.0.1;port=8889;dbname=game_app;charset=utf8mb4';
  $user = 'gamer';
  $pass = 'mattenkaitos';

  try{
    $dbh = new PDO($dsn, $user, $pass,[
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
  } catch(PDOException $e){
    echo '接続失敗'. $e->getMessage();
    exit();
  }
  return $dbh;
}

function getRank(){
  $dbh = dbConnect();

  $sql = 'SELECT id, name, score, FIND_IN_SET(
    score, (
      SELECT GROUP_CONCAT(
        score ORDER BY score DESC
      )
      FROM scores
    ) 
  ) AS rank
  FROM scores';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $result = $stmt->fetchall(PDO::FETCH_ASSOC);
  return $result;

  $dbh = null;
}

function setName($guestName){
  if(is_null($guestName)){
    return "ゲスト";
  }

  return $guestName;
}

function setScore($score){
  $sql = 'INSERT INTO scores(score)VALUE(:score)';

  $dbh = dbConnect();
  $dbh->beginTransaction();

  try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':score', $score, PDO::PARAM_INT);
    $stmt->execute();
    $dbh->commit();

  } catch(PDOException $e){
    $dbh->rollback();
    exit($e);
  }
}

function getLastId(){
  $sql = 'SELECT Max(id) from scores';
  $dbh = dbConnect();
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $lastId = $stmt->fetchall(PDO::FETCH_ASSOC);
  return $lastId;

  $dbh = null;
}

function updateName($name, $id){
  $sql = 'UPDATE scores SET name=:name WHERE id = :id';
  $dbh = dbConnect();
  $dbh->beginTransaction();

  try{
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
    $dbh->commit();

  } catch(PDOException $e){

    $dbh->rollback();
    exit($e);
  }
}

?>