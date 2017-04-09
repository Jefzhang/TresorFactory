<?php
class Recette
{
  public $id;
  public $eveId;
  public $poste;
  public $montant;

  public function __toString(){

  }

  public static function getRecette($dbh,$eveId){
    $query = "SELECT * FROM `recette` WHERE `eveId`=?";
    $sth = $dbh ->prepare($query);
    $sth->setFetchMode(PDO::FETCH_NUM);
    if (!$sth->execute(array($eveId))) {
        exit(0);
    }
    if ($sth->rowCount()==0) {
        return null;
    } else {
        return $sth->fetchAll();
    }
  }

  public static function insererRecette($dbh, $eveId,$poste,$num)
  {
          $sth = $dbh->prepare("INSERT INTO `recette` (`id`, `eveId`, `poste`,`montant`) VALUES(?,?,?,?)");
          $sth->execute(array(NULL,$eveId,$poste,$num));
  }

  public static function deleteRecette($dbh,$eveId){
    $sth = $dbh->prepare("DELETE FROM `recette` WHERE `eveId`= ?");
    $sth->execute(array($eveId));
  }

}

 ?>
