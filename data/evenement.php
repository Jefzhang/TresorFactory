<?php

class Evenement{
  public $name;

  public static function getMaxid($dbh){
    $query = "SELECT MAX(id) FROM `activityList`";
    $sth = $dbh->prepare($query);
    $sth->setFetchMode(PDO::FETCH_NUM);
    $sth->execute();
    return $sth->fetch()[0];
  }

  public static function getEvenement($dbh,$login){
    $query = "SELECT `activityList`.* FROM `activityList` JOIN `binetActivity` ON `activityList`.id = `binetActivity`.eveId WHERE `binetActivity`.binet = ? ORDER BY `activityList`.`date`";
    $sth = $dbh ->prepare($query);
    $sth ->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute(array($login));
    return $sth->fetchAll();
  }

  public static function insertEvenement($dbh,$name,$date,$description,$recette,$depence,$profit){
    $sth = $dbh->prepare("INSERT INTO `activityList` (`id`, `name`, `date`,`description`,`recette`,`depence`,`profit`) VALUES(?,?,?,?,?,?,?)");
    $sth->execute(array(NULL,$name,$date,$description,$recette,$depence,$profit));
  }

  public static function updateEvenement($dbh,$id,$name,$date,$description,$recette,$depence,$profit){
    $query =  "UPDATE `activityList` SET `name` = ?,`date`=?,`description`=?,`recette`=?,`depence`=?,`profit`=? WHERE `id` = ?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($name,$date,$description,$recette,$depence,$profit,$id));
  }

  public static function deleteEvenement($dbh,$id){
    $query = "DELETE FROM `activityList` WHERE `id`=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($id));
  }

}


?>
