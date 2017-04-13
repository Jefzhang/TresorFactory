<?php
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/evenement.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/user.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/binetEvenement.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/recette.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/depense.php');
session_name("tresor");
session_start();
$pemitted = false;

if($_SESSION['loggedIn']==true){
//  echo "loggedIN";
  $login = $_SESSION['login'];
  $dbh = Database::connect();
  $pemited = true;
  $arrayData = Evenement::getEvenement($dbh,$login);
  $newArray = array();
  foreach ($arrayData as $eve) {
    $eveId = $eve["id"];
    $sub = Depense::getMontantSub($dbh,$eveId);
    $montant = 0;
    foreach($sub as $value) {
      $montant = $montant + $value[0];
    }
    $eve = array_merge($eve,array("sub"=>$montant));
    array_push($newArray,$eve);
  }
  $result['oldSolde'] = Utilisateurs::getSolde($dbh,$login)[0];
  $result['sub'] = Utilisateurs::getSub($dbh,$login)[0];
  $result['data'] = $newArray;
  echo json_encode($result);
}
else{
  echo "<p>Pemission denied</p>";
  $pemited = false;
}
if($pemitted){

}
 ?>
