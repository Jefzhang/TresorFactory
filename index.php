<?php
require('utils/utils.php');
require('data/database.php');
require('data/loginOut.php');
$pageTitle = "TresorFactory";
generateHTMLHeader($pageTitle, "css");
session_name("tresor");
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
    $_SESSION['loggedIn'] = false;
}

$dbh = Database::connect();

//check if this user already existe

if (array_key_exists('todo', $_GET)) {
    if ($_GET['todo']=='login') {
        logIn($dbh);
    } elseif ($_GET['todo']=='logout') {
        logOut();
    }
}
echo<<<END
<div class="activity-modal " id="login-modal">
  <div class="login-form login-modal-content acti-modal-animate container-fluid">
    <form method="post" action="?todo=login" role="login" >
      <img src="images/TresorFactorylogo.png"  class="img-responsive" alt="">
      <p>
      <input type="text" name="login" placeholder="Nom de votre binet" data-validation="required" data-validation-error-msg="Nom de binet invalide" class="form-control input-lg" required>
      </p>
      <p>
      <input type="password" class="form-control input-lg" id="password" name="pass" placeholder="Mot de passe" data-validation="required" data-validation-erroe-msg="Mot de passe invalide">
      </p>
      <div class="pwstrength_viewport_progress"></div>
      <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Se connecter</button>
      <div>
        <a href="http://localhost/project/register.php">Create account</a> or <a href="http://localhost/project/resetpass.php">Reset password</a>
      </div>
    </form>

    <div class="form-links">
      <a href="http://localhost/project/index.php" style="color:#4da6ff">www.tresorfactory.com</a>
    </div>
  </div>
</div>

END;

if(isset($_SESSION['loggedIn'])){
  generateMenu($_SESSION['loggedIn']);
}
else{
  generateMenu(false);
}
if (isset($_SESSION['loggedIn'])&&$_SESSION["loggedIn"]) {         //already log in
  //generateMenu();
  if(isset($_GET['p'])){
    //echo "<div class=\"container-fluid\">";
    //echo "<div class=\"row\">";
    $page = $_GET['p'];
    if($page=='home')  require("content/home.php");
    else if($page=='compte'){
      //echo Utilisateurs::getUtilisateur($dbh,$_SESSION['login']);
      require("content/compte.php");
    }
    else if($page=='activity'){
      require("content/activity.php");
    }
    else if($page=='deman'){
      require("content/demande.php");
    }
    else if($page=='user'){
      require("data/admin.php");
    }
    //echo "</div";
    //echo "</div";
  }
  else{
    require("content/home.php");
  }
}else {
  if(isset($_GET['p'])){
    $page = $_GET['p'];
    if($page=='home') require ("content/home.php");
    else{
      printLoginForm();
    }
  }
  else{
    require ("content/home.php");
  }

}


generateHTMLFooter();


?>
<script>
$.validate({
});
$("#seConnecter").on('click',function(e){
 $("#login-modal").css('display','block');
})
var loginModal = document.getElementById('login-modal');
window.onclick = function(event) {
 if(event.target==loginModal){
   loginModal.style.display="none";
 }
}
</script>
