<?php

class Utilisateurs
{
    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $poste;
    public $promo;
    public $email;
    public $solde;

    public function __toString()
    {
      /*
        $str = "Binet: "."[$this->login]".""." $this->nom,"." ne le ";
        $date = explode("-", $this->naissance);
        $str = $str.$date[2]."/".$date[1]."/".$date[0].",";
        if ($this->promotion != null) {
            $str = $str."X".$this->promotion.",";
        }
        $str = $str.$this->email;
        $str = $str."  <a href='http://localhost/TD3/dataTest.php?login=$this->login'>Voir ses amis</a>";
        return $str;
        */
        $str = "Votre Binet: "."[$this->login]"." "."Solde: "."$this->solde";
        return $str;
    }


    public static function getUtilisateur($dbh, $login)
    {
        $query = "SELECT * FROM `binetlist` WHERE `login`=?";
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
    }

    public static function insererUtilisateur($dbh, $login, $mdp, $nom,$prenom,$poste,$promo,$email,$solde)
    {
        if (self::getUtilisateur($dbh, $login)==null) {
            $sth = $dbh->prepare("INSERT INTO `binetlist` (`login`, `mdp`, `nom`,`prenom`,`poste`,`promo`,`email`,`solde`) VALUES(?,SHA1(?),?,?,?,?,?,?)");
            $sth->execute(array($login,$mdp,$nom,$prenom,$poste,$promo,$email,$solde));
        }
    }

    public static function testerMdp($user, $mdp)
    {
        //$user = self::getUtilisateur($dbh,$login);
       if ($user->mdp == SHA1($mdp)) {
           return "true";
       } else {
           return "false";
       }
    }

    public static function changePassword($dbh,$login,$newPass){
      $query = "UPDATE `binetlist` SET `mdp`=? WHERE `login`=?";
      $sth = $dbh->prepare($query);
      $sth->execute(array(SHA1($newPass),$login));
    }

    public static function deleteUser($dbh,$login){
      $query = "DELETE FROM `binetlist` WHERE `login`=?";
      $sth = $dbh->prepare($query);
      $sth->execute(array($login));
    }
}
?>
