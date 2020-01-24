<?php 
include_once ('./services/bdd.php');

class User implements JsonSerializable {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;

    function __construct($id, $nom, $prenom, $email, $telephone) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'email' => $this->getEmail(),
            'telephone' => $this->getTelephone(),
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        return $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        return $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        return $this->prenom = $prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        return $this->email = $email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        return $this->telephone = $telephone;
    }
    
    public static function allUser() {
        global $dbh;
        $queryTest = "SELECT * from user";
        $req = $dbh->prepare($queryTest);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        if(!$res) throw new Exception('Ressource non existante');
        $req->closeCursor();

        return $res;
    }

    public static function getOne($email, $justChecking) {
        global $dbh;
        $queryTest = "SELECT * from user WHERE email = '".$email."'";
        
	    $req = $dbh->prepare($queryTest);
	    $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if(!$justChecking && !$result) throw new Exception('Ressource non existante');
        $req->closeCursor();
        return $result;
    }

    public function create($user) {
        global $dbh;
        if(isEmpty($user->nom) || isEmpty($user->prenom) || isEmpty($user->email) || isEmpty($user->telephone)) throw new Exception('Tous les champs ne sont pas remplis');
    
        $query = "INSERT INTO user (nom, prenom, email, telephone) VALUES (:nom, :prenom, :email, :telephone)";
        $req = $dbh->prepare($query);
        $req->execute(array(
            ':nom' => $user->getNom(),
            ':prenom' => $user->getPrenom(),
            ':email' => $user->getEmail(),
            ':telephone' => $user->getTelephone(),
        )) or die(print_r($req->errorInfo()));
        $req->closeCursor();
        $query = "SELECT LAST_INSERT_ID()";
        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $res = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $user->setId($res['LAST_INSERT_ID()']);
        return $user;
    }

    public function patch($id, $user) {
        global $dbh;
        
        $query = "UPDATE user SET";   
        if(!isEmpty($user->getNom())) {
            $query .= " nom = '".$user->getNom()."'";
        }
        if(!isEmpty($user->getPrenom())) {
            $query .= ", prenom = '".$user->getPrenom()."'";
        }
        
        if(!isEmpty($user->getEmail())) {
            $query .= ", email = '".$user->getEmail()."'";
        }
        if(!isEmpty($user->getTelephone())) {
            $query .= ", telephone = '".$user->getTelephone()."'";
        }  
        
        $query .= " WHERE id = ".$id;

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return $appointment;
    }

    public function delete($id) {
        global $dbh;
        
        $query = "DELETE FROM user WHERE id =".$id;   

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return 'Le client a bien été supprimé';
    }
}