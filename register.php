<?php

require "data/user.php";
require "/Applications/XAMPP/xamppfiles/htdocs/project/utils/utils.php";
require "data/database.php";
$dbh = Database::connect();

generateHTMLHeader("register","css");
$form_values_valid=false;
if(isset($_POST["login"]) && $_POST["login"] != "" &&
   isset($_POST["poste"]) && $_POST["poste"] != "" &&
   isset($_POST["nom"]) && $_POST["nom"] !="" &&
   isset($_POST["prenom"]) && $_POST["prenom"] !="" &&
   isset($_POST["promo"]) && $_POST["promo"] !="" &&
   isset($_POST["email"]) && $_POST["email"] != "" &&
   isset($_POST["tel"]) && $_POST["tel"] !=""
   ) {
     $login = $_POST["login"];
     $mdp1 = $_POST["pass1"];
     $mdp2 = $_POST["pass2"];
     $poste = $_POST["poste"];
     $nom = $_POST["nom"];
     $prenom = $_POST["prenom"];
     $promo = $_POST["promo"];
     //$naissance = $_POST["nai"];
     $email = $_POST["email"];
     $tel = $_POST["tel"];
     //$image = $_POST["image"];
     //$style = $_POST["style"];
     $user = Utilisateurs::getUtilisateur($dbh,$login);
     if($user==null){
       if($mdp1==$mdp2){
         $solde = 0;
         $sub = 0;
         Utilisateurs::insererUtilisateur($dbh,$login,$mdp1,$nom,$prenom,$poste,$promo,$email,$tel,$solde,$sub);
         //$imageoutput=basename($_FILES["image"]["name"]);
         //file_put_contents($imageoutput,$image);
        // move_uploaded_file($_FILES["image"]["tmp_name"], $imageoutput);
         $form_values_valid = true;
       }
     }

}

if (!$form_values_valid) {
  // code du formulaire, qui vient d'être écrit
  if (isset($_POST["login"])) $login = $_POST["login"];
  else {
    $login = "";
  }
  if (isset($_POST["prenom"])) $prenom = $_POST["prenom"];
  else $prenom = "";
  if (isset($_POST["nom"])) $nom = $_POST["nom"];
  else $nom = "";
  if (isset($_POST["promo"])) $naissance = $_POST["promo"];
  else $naissance = "";
  if (isset($_POST["email"])) $email = $_POST["email"];
  else $email = "";

echo<<<END
<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3 register-form">

<form role="register" method ="post" id="register-form" action="" class="row" enctype="multipart/form-data">
 <img src="images/TresorFactorylogo.png"  class="img-responsive" alt="">
  <div class="form-group">
    <label for="login">Nom de binêt</label>
    <input type="text" class="form-control" name="login" id="login" placeholder="Nom de votre binêt"  data-validation="required" data-validation-error-msg="Nom de binet invalide">
  </div>

  <div class="form-group">
    <label for="pass1">Mot de passe</label>
    <input type="password" class="form-control" name="pass1" id="pass1" placeholder="Votre mot de passe" data-validation="letternumeric" data-validation-error-msg="Seulement des lettres et des chiffres sont autorisées">
    <small id="passHelp" class="form-text text-muted">* Veuillez nutiliser que des chiffres et lettres</small>
  </div>

  <div class="form-group">
    <label for="pass2">Confirmation du mot de passe</label>
    <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Confirmez votre mot de passe" data-validation="confirmation" data-validation-error-msg="Les deux mots de passe sont différents">
  </div>

  <div class="form-group">
    <label for="nom">Nom</label>
    <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom" data-validation="required" data-validation-error-msg="Veuillez taper votre nom">
  </div>

  <div class="form-group">
    <label for="prenom">Prenom</label>
    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prenom" data-validation="required" data-validation-error-msg="Veuillez taper votre prenom">
  </div>

  <div class="form-group">
    <label for="poste">Vous êtes</label>
    <select class="form-control" name="poste" id="poste">
     <option>Prez</option>
     <option>Trez</option>
    </select>
  </div>

  <div class="form-group">
    <label for="promo">Promotion</label>
    <input type="text" class="form-control" name="promo" id="promo" placeholder="Vous êtes dans quelle promotion" data-validation="required" data-validation-error-msg="Veuillez taper votre promotion, ex X2015">
    <small id="promoHelp" class="form-text text-muted">* ex.X2015</small>
  </div>

  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Adresse de votre email">
  </div>

  <div class="form-group">
    <label for="tel">Portable</label>
    <input type="number" class="form-control" name="tel" id="tel" placeholder="Votre numéro de portable">
  </div>

  <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Créer un compte</button>
  <div class="form-links" style="text-align:center">
    <a href="http://localhost/project/index.php" style="color:#4da6ff">www.tresorfactory.com</a>
  </div>
</form>
</div>
</div>
</div>

  <script>
  $.validate({
    modules : 'security'
  });
</script>

END;
}
else{
  echo <<<END
  <div class="container-fluid"  style="text-align: center">
        <div class="jumbotron">
              <h1>Bienvenue à la monde de trésorier !</h1>
              <p>Grâce à cet outil, vous allez beaucoup facilement gerer le compte de votre binêt, planifier vos activités, demander les subventions, etc.</p>
              <p><a href="http://localhost/project/index.php">Découvrir tout de suite cet outil !</a></p>
          </div>
  </div>
END;
}
generateHTMLFooter();
?>
