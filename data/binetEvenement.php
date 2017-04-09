<?php
class binetEvenement
{
  public $id;
  public $login;
  public $eveId;

  public function __toString(){

  }

  public static function getEvenement($dbh,$eveId){
    $query = "SELECT * FROM `binetActivity` WHERE `eveId`=?";
    $sth = $dbh ->prepare($query);
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateurs');
    if (!$sth->execute(array($eveId))) {
        exit(0);
    }
    if ($sth->rowCount()==0) {
        return null;
    } else {
        return $sth->fetch();
    }
  }

  public static function insererEvenement($dbh, $login, $eveId)
  {
      if (self::getEvenement($dbh, $eveId)==null) {
          $sth = $dbh->prepare("INSERT INTO `binetActivity` (`id`, `binet`, `eveId`) VALUES(?,?,?)");
          $sth->execute(array(NULL,$login,$eveId));
      }
  }

  /*public static function testLogin($dbh,$login,$eveId){
    $binet = self::getEvenement($dbh,$eveId);

  }*/

  public static function deleteEvenement($dbh,$login,$eveId){
      $query = "DELETE FROM `binetActivity` WHERE `binet` =?AND `eveId`=?";
      $sth = $dbh->prepare($query);
      $sth->execute(array($login,$eveId));
  }

  public static function getDescription($dbh,$eveId){
    $query = "SELECT `description` FROM `activityList` WHERE `id`=?";
    $sth = $dbh -> prepare($query);
    $sth->setFetchMode(PDO::FETCH_NUM, 'Utilisateurs');
    if (!$sth->execute(array($eveId))) {
        exit(0);
    }
    if ($sth->rowCount()==0) {
        return null;
    } else {
        return $sth->fetch();
    }
  }
}

 ?>
