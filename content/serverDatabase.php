<?php
  session_name("tresor");
  session_start();
  require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
  require('/Applications/XAMPP/xamppfiles/htdocs/project/data/binetEvenement.php');
  require('/Applications/XAMPP/xamppfiles/htdocs/project/data/recette.php');
  require('/Applications/XAMPP/xamppfiles/htdocs/project/data/depense.php');

  $pemited = false;
  //file_put_contents("http.txt",$_SESSION['loggedIn'], FILE_APPEND | LOCK_EX);

  //echo implode(" ",$_SESSION);
  if($_SESSION['loggedIn']==true){
  //  echo "loggedIN";
    $login = $_SESSION['login'];
    $dbh = Database::connect();
    $pemited = true;

    //$jsonFile = file_get_contents("$dir/data.json");   //Get a string file
    //$jsonFile = json_decode($jsonFile,true);

  }
  else{
    echo "<p>Pemission denied</p>";
    $pemited = false;
  }

  if($pemited){
    $action = $_POST["action"];
    if($action == 'add'){
      $eveId = $_POST['eveId'];
      binetEvenement::insererEvenement($dbh,$login,$eveId);
      echo "add success";
    }
    else if($action == 'addD'){
      $data = json_decode($_POST["data"],true);
      $eveId = $data["eveId"];
      $recette = $data["recette"];
      $depense = $data["depense"];
      Recette::deleteRecette($dbh,$eveId);
      Depense::deleteDepense($dbh,$eveId);
      foreach ($recette as $item) {
        Recette::insererRecette($dbh,$eveId,$item[0],$item[1]);
      }
      foreach ($depense as $item) {
        Depense::insererDepense($dbh,$eveId,$item[0],$item[1],$item[2]);
      }
      echo "add detaille success";
    }
    else if($action == 'modifD'){
      $eveId = $_POST["eveId"];
      $recette = Recette::getRecette($dbh,$eveId);
      $depense = Depense::getDepense($dbh,$eveId);

      $newRecette = array();
      $newDepense = array();
      foreach ($recette as $item) {
        $item = array_slice($item,2,2);
        array_push($newRecette,$item);
      }
      foreach ($depense as $item) {
        $item = array_slice($item,2,3);
        array_push($newDepense,$item);
      }
      $data = array("recette"=>$newRecette,"depense"=>$newDepense);
      //file_put_contents("http.txt", $newRecette, FILE_APPEND | LOCK_EX);
      echo json_encode($data);

      //file_put_contents("http.txt", "pp", FILE_APPEND | LOCK_EX);
      //file_put_contents("http.txt", $recette[0], FILE_APPEND | LOCK_EX);

    }
    else if($action == 'edit'){

    }
    else if($action == 'afficheD'){
      $eveId = $_POST['eveId'];
      $description = binetEvenement::getDescription($dbh,$eveId);
      $recette = Recette::getRecette($dbh,$eveId);
      $depense = Depense::getDepense($dbh,$eveId);
      $newRecette = array();
      $newDepense = array();
      foreach ($recette as $item) {
        $item = array_slice($item,2,2);
        array_push($newRecette,$item);
      }
      foreach ($depense as $item) {
        $item = array_slice($item,2,3);
        array_push($newDepense,$item);
      }
      $data = array("descrip"=>$description,"recette"=>$newRecette,"depense"=>$newDepense);
      echo json_encode($data);

    }
    /*require("jsonUtil.php");
    if(!isset($_GET["t"])||$_GET["t"]=="all"){          //load the information of all the activities
      //$json = getGeneralInfofActivi($jsonFile);
      echo json_encode($jsonFile);
    //  echo $json;
    }else if($_GET["t"]=="single"){  //load only the information of the page requested

      if(isset($_GET["name"])) $name = $_GET["name"];
      $json = getSingleInfoActivi($jsonFile,$name);
      echo $json;

    }*/
  }
?>
