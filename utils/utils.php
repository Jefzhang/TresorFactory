<?php
$page_list = array(
  array(
    "name" =>"home",
    "title" =>"Make this world different",
    "menutitle" =>"TresorFactory"),
  array(
    "name" =>"compte",
    "title" => "Voir le compte de votre binet",
    "menutitle" =>"Compte"),
  array(
    "name" =>"activity",
    "title" => "Gerer mieux vos activités",
    "menutitle" => "Acitivités"),
  array(
    "name" =>"sub",
    "title" =>"Demande subvention pour votre binet",
    "menutitle" =>"Demande"),
  );

/*
 Generate the navigation of the page, and use ajax load page content
*/
function generateMenu($loggedIn)
{
    global $page_list;
    echo<<<END
      <div class="navbar navbar-default" id="menu">
          <nav class="container">
          <div class="navbar-header">
               <a class="navbar-brand" href="http://localhost/project/index.php?p=home">
                  Brandimage
              </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">TresorFactory</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
          </div>

         <div class="collapse navbar-collapse" id="bd-main-nav">
          <ul class="nav navbar-nav">
             <li class="nav-item">
                 <a class="nav-item nav-link" href="http://localhost/project/index.php?p=home">TresorFactory</a>
             </li>
END;
    for ($i=1;$i<count($page_list);$i++) {
        $page=$page_list[$i];
        $name = $page["name"];
        $title = $page["menutitle"];
        echo<<<END
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/project/index.php?p=$name">$title </a>
          </li>
END;
    }
    echo "</ul>";

    if($loggedIn){
    echo<<<END
  <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Mon compte <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li><a href="?p=user">Administration</a></li>
              <li><a href="#">Supprimer mon compte</a></li>
              <li><a href="?todo=logout">Log out</a></li>
          </ul>
      </li>
  </ul>
END;
}
else{
  echo<<<END
  <ul class="nav navbar-nav navbar-right">
    <li class = "nav-item" id="seConnecter">
       <a class="nav-link" href="#">Se connecter</a>
    </li>
    <li class="nav-item">
       <a class="nav-link" href="http://localhost/project/register.php">Créer un compte</a>
    </li>
  </ul>
END;
}
  echo "</div>";
  echo "</nav>";
  echo "</div>";

}

function printLoginForm(){

  /*<div class="container">
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="login-form">
        <form method="post" action="?todo=login" role="login">
          <img src="http://i.imgur.com/RcmcLv4.png" class="img-responsive" alt="">
          <p>
          <input type="text" name="login" placeholder="Nom de votre binet" data-validation="required" data-validation-error-msg="Nom de binet invalide" class="form-control input-lg" required>
          </p>
          <p>
          <input type="password" class="form-control input-lg" id="password" name="pass" placeholder="Mot de passe" data-validation="required" data-validation-erroe-msg="Mot de passe invalide">
          </p>
          <div class="pwstrength_viewport_progress"></div>
          <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
          <div>
            <a href="http://localhost/project/register.php">Create account</a> or <a href="#">reset password</a>
          </div>
        </form>

        <div class="form-links">
          <a href="http://localhost/project/index.php">www.tresorfactory.com</a>
        </div>
      </div>
      </div>
  </div>
</div>*/
 echo<<<END
 <script>
   $("#login-modal").css("display","block");
 </script>
END;
}

function checkPage($askedPage)
{
    global $page_list;
    foreach ($page_list as $page) {
        if ($page["name"] == $askedPage) {
            return true;
        }
    }
    return false;
}

function getPageTitle($askedPage)
{
    //global $authorized;
  global $page_list;
    foreach ($page_list as $page) {
        if ($page["name"] == $askedPage) {
            return $page["title"];
        }
    }
    return "Unknown";
}
function generateHTMLHeader($title, $link)
{
    echo "<!DOCTYPE html>";
    echo "<html>".PHP_EOL;
    $linkBoot = $link."/bootstrap.css";
    $linkPerso = $link."/perso.css";
    echo <<<END
  <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
     <meta name="author" content="Jianfei"/>
     <meta name="keywords" content="Sub gestion"/>
     <meta name="description" content="Descriptif court"/>
     <title>$title</title>
     <link href=$linkBoot rel="stylesheet">
     <link href=$linkPerso rel="stylesheet">
     <link href="css/jquery.dataTables.min.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css">
     <link rel="stylesheet" type="text/css" href="css/editor.dataTables.css">
     <link rel="stylesheet" type="text/css" href="css/editor.bootstrap.css">
     <link rel="stylesheet" href="css/jquery.jexcel.css" type="text/css">


     <script type="text/javascript" src="js/jquery-1.12.4.js"></script>
     <script type="text/javascript" src="js/bootstrap.js"></script>

     <script type="text/javascript" src="js/dataTables.min.js"></script>
     <script type="text/javascript" src="js/dataTables.editor.js"></script>
     <script type="text/javascript" src="js/jquery.validate.min.js"></script>
     <script language="javascript" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
     <script language="javascript" type="text/javascript" src="js/jqplot.pieRenderer.js"></script>
     <script type="text/javascript" src="js/moment.js"></script>
     <script type="text/javascript" src="js/jquery.jexcel.js"></script>
     </head>
END;
    echo "<body>".PHP_EOL;
}

function generateMatrix($taille)
{
    echo "<h1>Deuxième exercice</h1>".PHP_EOL;
    echo "<h2>Matrice carrée de taille ".$taille."</h2>";
    echo "<p>".PHP_EOL;
    echo "<table class=\"table table-bordered\">";
    for ($i=1;$i<=$taille;$i++) {
        echo "<tr>".PHP_EOL;
        for ($j=1;$j<=$taille;$j++) {
            echo "<td>".$i.",".$j."</td>".PHP_EOL;
        }
        echo "</tr>".PHP_EOL;
    }
    echo "</p>".PHP_EOL;
}

function generateHTMLFooter()
{
    echo<<<END
END;
    echo "</body>";
    echo "</html>";
}
