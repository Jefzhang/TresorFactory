<?php
class Depense
{
  public $id;
  public $eveId;
  public $poste;
  public $montant;
  public $sub;

  public function __toString(){

  }

  public static function getDepense($dbh,$eveId){
    $query = "SELECT * FROM `depense` WHERE `eveId`=?";
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


  public static function insererDepense($dbh, $eveId,$poste,$montant,$sub)
  {
          $sth = $dbh->prepare("INSERT INTO `depense` (`id`, `eveId`, `poste`,`montant`,`sub`) VALUES(?,?,?,?,?)");
          $sth->execute(array(NULL,$eveId,$poste,$montant,$sub));
  }

  public static function deleteDepense($dbh,$eveId){
    $sth = $dbh->prepare("DELETE FROM `depense` WHERE `eveId`= ?");
    $sth->execute(array($eveId));
  }

  public static function getMontantSub($dbh,$eveId){
    $query = "SELECT `montant` FROM `depense` WHERE `sub`=? AND `eveId`=?";
    $sth = $dbh->prepare($query);
    $sth->setFetchMode(PDO::FETCH_NUM);
    $sth->execute(array(1,$eveId));
    return $sth->fetchAll();
  }

}

 ?>
