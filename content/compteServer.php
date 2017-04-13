<?php
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
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
/*  $arrayData = Evenement::getEvenement($dbh,$login);
  foreach ($arrayData as $evenement) {
    $evenement["id"] =
  }*/


}
else{
  echo "<p>Pemission denied</p>";
  $pemited = false;
}
if($pemitted){

}
 ?>
