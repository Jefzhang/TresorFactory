<?php
require('data/database.php');
require ('data/loginOut.php');
require('utils/utils.php');
session_name("tresor");
session_start();
$pageTitle = "Change password";
generateHTMLHeader($pageTitle, "css");
$dbh = Database::connect();
$form_values_valid=false;
echo<<<END
 <div class="activity-modal" id="reset-modal">
  <div class="login-form login-modal-content acti-modal-animate container-fluid">
    <form method="post" action="?todo=changePass" method="post" id="resetpass" role="login">
      <img src="images/TresorFactorylogo.png"  class="img-responsive" alt="">
      <p>
      <input type="text" name="login" placeholder="Nom de binet ou votre nom" id="resetLogin" data-validation="required" data-validation-error-msg="Utilisateur invalide" class="form-control input-lg" required>
      </p>
      <p>
      <input type="password" class="form-control input-lg" id="password1" name="pass1" placeholder="Mot de passe originale" data-validation="letternumeric" data-validation-error-msg="Seulement des lettres et des chiffres sont autorisées">
      </p>
      <p>
      <input type="password" class="form-control input-lg" id="password2" name="pass2" placeholder="Mot de passe nouvelle" data-validation="letternumeric" data-validation-error-msg="Seulement des lettres et des chiffres sont autoriséese">
      </p>
      <p>
      <input type="password" class="form-control input-lg" id="password3" name="pass3" placeholder="Confirmation" data-validation="confirmation" data-validation-error-msg="Les deux mots de passe sont différents">
      </p>
      <div class="pwstrength_viewport_progress"></div>
      <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Valiter</button>
      <div style="text-align:center">
        <a href="http://localhost/project/register.php">Creér un compte</a>
      </div>
    </form>
    <div class="form-links">
      <a href="http://localhost/project/index.php" style="color:#4da6ff">www.tresorfactory.com</a>
    </div>
  </div>
  </div>
END;

if(isset($_GET["todo"])&&$_GET["todo"]=="changePass"){
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
            if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']){
              logOut();
            }
            resetMdpSuccess();
         }
       }
       else {
         wrongPass();
       }
     }
     else {
       wrongPass();
     }

}

else{
  echo<<<END
  <script>
    $("#reset-modal").css("display","block");
  </script>
END;
}
generateHTMLFooter();
 ?>

<script>
$.validate({
  modules : 'security'
});
</script>
