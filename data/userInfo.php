<?php
session_name("tresor");
session_start();
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php');
require('/Applications/XAMPP/xamppfiles/htdocs/project/data/user.php');


$pemited = false;
//file_put_contents("http.txt",$_SESSION['loggedIn'], FILE_APPEND | LOCK_EX);

if($_SESSION['loggedIn']==true){
//  echo "loggedIN";
  $login = $_SESSION['login'];
  $dbh = Database::connect();
  $pemited = true;
}
else{
  echo "<p>Pemission denied</p>";
  $pemited = false;
}
if($pemited){
  if($_GET['a']=='g'){
    echo json_encode(Utilisateurs::getUtilisateurArray($dbh,$login));
  }
  else if($_GET['a']=='c'){
    $id = $_POST['id'];
    $value  = $_POST['value'];
    //echo $value;
    echo Utilisateurs::changeInfo($dbh,$login,$id,$value);
  }

}


?>
