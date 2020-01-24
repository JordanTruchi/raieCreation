<?php 
include_once ('./services/bdd.php');

class Appointment implements JsonSerializable {
    private $id;
    private $idUser;
    private $dateTime;

    function __construct($id, $idUser, $dateTime) {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->dateTime = $dateTime;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'idUser' => $this->getIdUser(),
            'dateTime' => $this->getDateTime(),
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        return $this->id = $id;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function setIdUser($idUser) {
        return $this->idUser = $idUser;
    }

    public function getDateTime() {
        return $this->dateTime;
    }

    public function setDateTime($dateTime) {
        return $this->dateTime = $dateTime;
    }
    
    

    /* public function setImages($images) {
        if(gettype($images) === 'string')
            return $this->images = json_decode($images);
        else 
            return $this->images = $images;
    }
 */
    public static function allAppointment() {
        global $dbh;
        $queryTest = "SELECT appointment.id, appointment.dateTime, user.id as idUser, user.nom, user.prenom, user.telephone, user.email from appointment, user WHERE appointment.id_user = user.id ORDER BY appointment.dateTime";
        $req = $dbh->prepare($queryTest);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        if(!$res) throw new Exception('Ressource non existante');
       /*  foreach ($res as $key => $value) {
            $res[$key]['images'] = json_decode($value['images']);
        } */
        $req->closeCursor();

        return $res;
    }

    public static function getOne($id) {
        global $dbh;
        $queryTest = "SELECT appointment.id, appointment.dateTime, user.id as idUser, user.nom, user.prenom, user.telephone, user.email from appointment, user WHERE appointment.id =".$id;
	    $req = $dbh->prepare($queryTest);
	    $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        /* $result['images'] = json_decode($result['images']); */
        if(!$result) throw new Exception('Ressource non existante');
	    $req->closeCursor();
        return $result;
    }

    public function create($appointment, $user, $justChecking) {
        global $dbh;
        if(isEmpty($appointment->dateTime) || isEmpty($user->getNom()) || isEmpty($user->getPrenom()) || isEmpty($user->getEmail()) || isEmpty($user->getTelephone())) throw new Exception('Tous les champs ne sont pas remplis');
        
        /* $goodFormatImages = [];
        foreach ($appointment->images as $key => $image) {
            $target_file = TARGET_DIR . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            move_uploaded_file($image["tmp_name"], $target_file);
            $tempObject = new stdClass();
            $tempObject->url = '/todoList/back/api'.str_replace('.', '', TARGET_DIR).$image['name'];
            $tempObject->name = str_replace('.'.$imageFileType, '', $image['name']);
            array_push($goodFormatImages, $tempObject);
        }
        $appointment->setImages($goodFormatImages); */
        $userExist = user::getOne($user->getEmail(), $justChecking);
        
        if(!$userExist) {
            $userExist = $user->create($user);
        }
        gettype($userExist) === "object" ? $user->setId($userExist->getId()) : $user->setId($userExist['id']);
        $query = "INSERT INTO appointment (id_user, dateTime) VALUES (:idUser, :date)";
        $req = $dbh->prepare($query);
        $req->execute(array(
            ':idUser' => $user->getId(),
            ':date' => $appointment->getDateTime(),
        )) or die(print_r($req->errorInfo()));
        $req->closeCursor();
        $query = "SELECT LAST_INSERT_ID()";
        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $res = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $appointment->setId($res['LAST_INSERT_ID()']);
        $appointment->setIdUser($user->getId());
        return [$appointment, $user];
    }

    public function patch($id, $appointment) {
        global $dbh;
        
        $query = "UPDATE appointment SET";   
        if(!isEmpty($appointment->getNameUser())) {
            $query .= " name = '".$appointment->getName()."'";
        }
        if(!isEmpty($appointment->getDateTime())) {
-            $query .= ", date = '".$appointment->getDate()."'";
        } 
        
        /* if(!isEmpty($appointment->getImages())) {
            $goodFormatImages = [];
            foreach ($appointment->images as $key => $image) {
                $target_file = TARGET_DIR . basename($image["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                move_uploaded_file($image["tmp_name"], $target_file);
                $tempObject = new stdClass();
                $tempObject->url = '/todoList/back/api'.str_replace('.', '', TARGET_DIR).$image['name'];
                $tempObject->name = str_replace('.'.$imageFileType, '', $image['name']);
                array_push($goodFormatImages, $tempObject);
            }
            $appointment->setImages($goodFormatImages);
            $query .= ", images = '".json_encode($appointment->getImages())."'";
        }  */
        $query .= " WHERE id = ".$id;

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return $appointment;
    }

    public function delete($id) {
        global $dbh;
        
        $query = "DELETE FROM appointment WHERE id =".$id;   

        $req = $dbh->prepare($query);
        $req->execute() or die(print_r($req->errorInfo()));
        $req->closeCursor();
        
        return 'Le rendez-vous a bien été supprimé';
    }
}