<?php
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/evenement.php');
session_name("tresor");
session_start();

function validate($name,$date,$description,$recette,$depence,$profit){
  $error = false;
  $fielderros = array();
  if($name==""){
    $error = true;
    array_push($fielderros,array("name"=>"name","status"=>"This field is required"));
  }
  if($date==""){
    $error = true;
    array_push($fielderros,array("name"=>"date","status"=>"This field is required"));
  }
  else if(!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/",$date)){
    array_push($fielderros,array("name"=>"date","status"=>"The date should be yyyy-mm-dd"));
  }
  if($description==""){
    $error = true;
    array_push($fielderros,array("name"=>"description","status"=>"This field is required"));
  }
  if($depence==""){
    $error = true;
    array_push($fielderros,array("name"=>"depence","status"=>"This field is required"));
  }
  else if(!is_numeric($depence)){
    $error = true;
    array_push($fielderros,array("name"=>"depence","status"=>"This field should be numeric"));
  }
  if($recette==""){
    $erroe = true;
    array_push($fielderros,array("name"=>"recette","status"=>"This field is required"));
  }
  else if(!is_numeric($recette)){
    $error = true;
    array_push($fielderros,array("name"=>"recette","status"=>"This field should be numeric"));
  }
  if($profit==""){
    $erroe = true;
    array_push($fielderros,array("name"=>"profit","status"=>"This field is required"));
  }
  else if(!is_numeric($profit)){
    $error = true;
    array_push($fielderros,array("name"=>"profit","status"=>"This field should be numeric"));
  }
  return array($error,$fielderros);

}

if($_SESSION['loggedIn']){
    $dbh = Database::connect();
  if($_POST["action"]=="create"){
    $data = $_POST["data"][0];
    $name = $data["name"];
    $date = $data["date"];
    $description = $data["description"];
    $depence = $data["depence"];
    $recette = $data["recette"];
    $profit = $data["profit"];
    list($error,$fielderros) = validate($name,$date,$description,$recette,$depence,$profit);
    $data = array();

    if($error){
      $result['data'] = $data;
      $result['fieldErrors'] = $fielderros;
      echo json_encode($result);
    }
    else{
      //$dateforme = date_create_from_format('j-m-y', $date);
      //$date = date_format($dateforme,'Y-m-d');
      Evenement::insertEvenement($dbh,$name,$date,$description,$recette,$depence,$profit);
      $id = Evenement::getMaxid($dbh);
      $rowId = "row_".$id;
      $eveArray = array("DT_RowId"=>$rowId,"name"=>$name,"date"=>$date,"description"=>$description,"recette"=>$recette,"depence"=>$depence,"profit"=>$profit);
      $eve = array();
      array_push($eve,$eveArray);
      $result["data"]=$eve;
      echo json_encode($result);
    }
  }
  else if($_POST["action"]=="edit"){
    $data = $_POST["data"];
    foreach ($data as $rowId => $value) {
      $id = explode("_",$rowId)[1];
      $name = $value["name"];
      $date = $value["date"];
      $description = $value["description"];
      $recette = $value["recette"];
      $depence = $value["depence"];
      $profit = $value["profit"];
      $data = array();
      list($error,$fielderros) = validate($name,$date,$description,$recette,$depence,$profit);
      if($error){
        $result['data'] = $data;
        $result['fieldErrors'] = $fielderros;
        echo json_encode($result);
      }
      else{
        //$dateforme = date_create_from_format('j-m-y', $date);
        //$date = date_format($dateforme,'Y-m-d');
        Evenement::updateEvenement($dbh,$id,$name,$date,$description,$recette,$depence,$profit);
      //  $id = Evenement::getMaxid($dbh);
      //  $rowId = "row_".$id;
        $eveArray = array("DT_RowId"=>$rowId,"name"=>$name,"date"=>$date,"description"=>$description,"recette"=>$recette,"depence"=>$depence,"profit"=>$profit);
        $eve = array();
        array_push($eve,$eveArray);
        $result["data"]=$eve;
        echo json_encode($result);
      }

    }
  }
  else if($_POST["action"]=="remove"){
    $data = $_POST["data"];
    foreach ($data as $rowId => $value) {
      $id = explode("_",$rowId)[1];
      Evenement::deleteEvenement($dbh,$id);
      echo json_encode(new stdClass);
  }
}
}


?>
