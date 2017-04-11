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
    public $sub;

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

    public static function getUtilisateurArray($dbh,$login){
      $query = "SELECT * FROM `binetlist` WHERE `login`=?";
      $sth = $dbh ->prepare($query);
      $sth->setFetchMode(PDO::FETCH_ASSOC);
      if (!$sth->execute(array($login))) {
          exit(0);
      }
      if ($sth->rowCount()==0) {
          return null;
      } else {
          return $sth->fetch();
      }
    }

    public static function insererUtilisateur($dbh, $login, $mdp, $nom,$prenom,$poste,$promo,$email,$solde,$sub)
    {
        if (self::getUtilisateur($dbh, $login)==null) {
            $sth = $dbh->prepare("INSERT INTO `binetlist` (`login`, `mdp`, `nom`,`prenom`,`poste`,`promo`,`email`,`solde`) VALUES(?,SHA1(?),?,?,?,?,?,?,?)");
            $sth->execute(array($login,$mdp,$nom,$prenom,$poste,$promo,$email,$solde,$sub));
        }
    }

    public static function changeInfo($dbh,$login,$id,$value){
      switch($id)
      {
        case 'login':{
          return self::changeLogin($dbh,$login,$value);
          break;
        }
        case 'nom':{
          return self::changeNom($dbh,$login,$value);
          break;
        }
        case 'prenom':{
          return self::changePrenom($dbh,$login,$value);
          break;
        }
        case 'poste':{
          return self::changePoste($dbh,$login,$value);
          break;
        }
        case 'email':{
          return self::changeEmail($dbh,$login,$value);
          break;
        }
        case 'tel':{
          return self::changeTel($dbh,$login,$value);
          break;
        }
        case 'solde':{
          return self::changeSolde($dbh,$login,$value);
          break;
        }
        case 'sub':{
          return self::changeSub($dbh,$login,$value);
          break;
        }

      }

    }

    public static function changeLogin($dbh,$login,$newlogin){
      $query = "UPDATE `binetlist` SET `login` = ? WHERE `login` = ?";
      $sth = $dbh ->prepare($query);
      $sth ->execute(array($newlogin,$login));
      $_SESSION['login']=$newlogin;
      return $newlogin;
    }

    public static function changeNom($dbh,$login,$newNom){
      $query = "UPDATE `binetlist` SET `nom` = ? WHERE `login` = ?";
      $sth = $dbh ->prepare($query);
      $sth ->execute(array($newNom,$login));
      return $newNom;
    }

    public static function changePrenom($dbh,$login,$newPrenom){
      $query = "UPDATE `binetlist` SET `prenom` = ? WHERE `login` = ?";
      $sth = $dbh ->prepare($query);
      $sth ->execute(array($newPrenom,$login));
      return $newPrenom;
    }

    public static function changePoste($dbh,$login,$newPoste){
      $query = "UPDATE `binetlist` SET `poste` = ? WHERE `login` = ?";
      $sth = $dbh ->prepare($query);
      $sth ->execute(array($newPoste,$login));
      return $newPoste;
    }

    public static function changeEmail($dbh,$login,$newEmail){
      $pattern = '/^[a-zA-Z0-9.!#$%&\'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
    //  if (preg_match($pattern,$newEmail)){
      if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
        $query = "UPDATE `binetlist` SET `email` = ? WHERE `login` = ?";
        $sth = $dbh ->prepare($query);
        $sth ->execute(array($newEmail,$login));
        return $newEmail;
      }
      else return "Email non-valide";

    }

    public static function changeTel($dbh,$login,$newTel){
      $pattern ='/^[0-9]{10}$/';
      if (preg_match($pattern,$newTel)==1){
        $query = "UPDATE `binetlist` SET `tel` = ? WHERE `login` = ?";
        $sth = $dbh ->prepare($query);
        $sth ->execute(array($newTel,$login));
        return $newTel;
      }else{
        return "Portable non-valide";
      }
    }

    public static function changeSolde($dbh,$login,$newSolde){
      if(is_numeric($newSolde)){
        $query = "UPDATE `binetlist` SET `solde` = ? WHERE `login` = ?";
        $sth = $dbh ->prepare($query);
        $sth ->execute(array($newSolde,$login));
        return $newSolde;
      }
      else return "Chiffres demandés";
    }


    public static function changeSub($dbh,$login,$newSub){
      if(is_numeric($newSub)){
        $query = "UPDATE `binetlist` SET `sub` = ? WHERE `login` = ?";
        $sth = $dbh ->prepare($query);
        $sth ->execute(array($newSub,$login));
        return $newSub;
      }else return "Chiffres demandés";

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
