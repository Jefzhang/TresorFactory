<?php
require 'user.php';
function logIn($dbh){
  if (array_key_exists('login', $_POST)) {
      $login = $_POST['login'];
  } else {
      $login = "harry.potter";
  }
  if (array_key_exists('pass',$_POST)){
    $mdp = $_POST['pass'];
  }else {
    $mdp = NULL;
  }
  $user = Utilisateurs::getUtilisateur($dbh,$login);
  //print_r($user);
  if($user==null) return "Cet utilisateur n'existe pas";
  else {
    if(Utilisateurs::testerMdp($user,$mdp)){
      $_SESSION['loggedIn']=true;
      $_SESSION['login']=$login;
      return "Bienvenue!";
    }else {
      $_SESSION['loggedIn']=false;
      return "code false";
    }
  }
}

function logOut(){
  unset($_SESSION['loggedIn']);
  session_unset();
  session_destroy();
}
 ?>
