<?php

require 'Utilisateur.php';
require 'database.php';
$dbh = Database::connect();
$form_values_valid=false;
if(isset($_GET["todo"])&&$_GET["todo"]=="changePass"){
  echo "<p>to change password</p>";
  if(isset($_POST["login"]) && $_POST["login"]!="" &&
     isset($_POST["pass1"]) && $_POST["pass1"]!="" &&
     isset($_POST["pass2"]) && $_POST["pass2"]!="" &&
     isset($_POST["pass3"]) && $_POST["pass3"]!=""
     )
     $login = $_POST["login"];
     $pass1 = $_POST["pass1"];
     $pass2 = $_POST["pass2"];
     $pass3 = $_POST["pass3"];
     $user = Utilisateurs::getUtilisateur($dbh,$login);
     if($user!=null){
       if(Utilisateurs::testerMdp($user,$pass1)){
         if($pass2==$pass3){
            Utilisateurs::changePassword($dbh,$login,$pass2);
            $form_values_valid=true;
         }
       }
       else {
         echo "<p>The original password is not correct</p>";
       }
     }
     else {
       echo "<p>Login doesn't exist</P>";
     }

}

if (!$form_values_valid){
  echo<<<END
  <form action="?todo=changePass" method=post>
  <p>
   <label for="login">login:</label>
   <input id="login" type="text" required name="login">
  </p>
  <p>
   <label for="password1">Your original password:</label>
   <input id="password1" type="password" required name="pass1">
  </p>
  <p>
   <label for="password2">Your new password:</label>
   <input id="password2" type="password" required name="pass2">
  </p>
  <p>
   <label for="password3">Confirm your password:</label>
   <input id="password3" type="password" required name="pass3">
  </p>
  <input type=submit value="Confirm">
  </form>
END;
}
else {
  echo "<p>Your password has been changed.</p>";
}

 ?>
