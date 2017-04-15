<?php
class Demande
{
  public static function getAllDemande($dbh,$login){
    $query = "SELECT * FROM `demande` WHERE `login`=?";
    $sth = $dbh ->prepare($query);
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateurs');
    if (!$sth->execute(array($login))) {
        exit(0);
    }
    if ($sth->rowCount()==0) {
        return null;
    } else {
        return $sth->fetch();
    }
  };

  public static function insertDemande($dbh,$binet,$date,$type,$somme,$part,$asomme,$lsomme,$lasomme){
    $sth = $dbh->prepare("INSERT INTO `demande` (`id`, `binet`, `date`,`type`,`recette`,`depence`,`profit`) VALUES(?,?,?,?,?,?,?)");
    $sth->execute(array(NULL,$name,$date,$description,$recette,$depence,$profit));
  }

}

 ?>
