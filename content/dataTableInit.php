<?php
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/binetEvenement.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/evenement.php');
session_name("tresor");
session_start();

if($_SESSION['loggedIn']==true){
  $login = $_SESSION['login'];
  $dbh = Database::connect();
  $arrayData = Evenement::getEvenement($dbh,$login);
  $newArray = array();
  foreach($arrayData as $eve){
    //file_put_contents("http.txt",json_encode($eve), FILE_APPEND | LOCK_EX);
    $rowId = "row_".$eve['id'];
    $newEve = array("DT_RowId"=>$rowId);
    $newEve = array_merge($newEve,array_slice($eve,1,6));
    array_push($newArray,$newEve);
  }
  $data[] = $newArray;
  $options[] = array();
  $files[] = array();
  $result['data'] = $newArray;
  $result['options'] = array();
  $result['files'] = array();
  $jsonData = json_encode($result);
  echo $jsonData;
  //file_put_contents("http.txt",$jsonData, FILE_APPEND | LOCK_EX);




}

 ?>
