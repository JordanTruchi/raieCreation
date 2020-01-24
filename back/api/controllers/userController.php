<?php
include ('./models/user.php');

function listUser() {
	try {
		$user = User::allUser();
		header('Content-Type: application/json');
		echo json_encode($list);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function oneUser($id) {
	try {
		$user = User::getOne($id);
		header('Content-Type: application/json');
		echo json_encode($user);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function postUser($nom, $prenom, $email, $telephone) {
	try {
		$user = new User('', $nom, $prenom, $email, $telephone);
		$postedUser = $user->create($user);
 		header('Content-Type: application/json');
		echo json_encode($postedUser, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function updateUser($id, $nom, $prenom, $email, $telephone) {
	try {
		$user = new User('', $nom, $prenom, $email, $telephone);
		$isUserExist = $user->getOne($id);
		$user = $user->patch($id, $user);
		$user->setId($id);
		if(isEmpty($user->getName())) $user->setName($isUserExist['name']);
		if(isEmpty($user->getDate())) $user->setDate($isUserExist['date']);
		header('Content-Type: application/json');
		echo json_encode($user, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function deleteUser($id) {
	try {
		$user = new User('', '', '', '', '', '');
		$isUserExist = $user->getOne($id);
		$messageIfDeleted = $user->delete($id);
		header('Content-Type: application/json');
		echo json_encode($messageIfDeleted, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}
?>