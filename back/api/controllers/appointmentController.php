<?php
include ('./models/appointment.php');
include ('./models/user.php');

function listAppointment() {
	try {
		$list = appointment::allAppointment();
		header('Content-Type: application/json');
		echo json_encode($list);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function oneAppointment($id) {
	try {
		$appointment = appointment::getOne($id);
		header('Content-Type: application/json');
		echo json_encode($appointment);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function postAppointment($date, $nom, $prenom, $email, $telephone) {
	try {
		$appointment = new Appointment('', '', $date);
		$user = new User('', $nom, $prenom, $email, $telephone);
		$postedAppointment = $appointment->create($appointment, $user, true);
 		header('Content-Type: application/json');
		echo json_encode($postedAppointment, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function updateAppointment($id, $name, $date) {
	try {
		$appointment = new Appointment('', $name, $date);
		$isAppointmentExist = $appointment->getOne($id);
		$appointment = $appointment->patch($id, $appointment);
		$appointment->setId($id);
		if(isEmpty($appointment->getName())) $appointment->setName($isAppointmentExist['name']);
		if(isEmpty($appointment->getDate())) $appointment->setDate($isAppointmentExist['date']);
		header('Content-Type: application/json');
		echo json_encode($appointment, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}

function deleteAppointment($id) {
	try {
		$appointment = new Appointment('', '', '', '', '', '');
		$isAppointmentExist = $appointment->getOne($id);
		$messageIfDeleted = $appointment->delete($id);
		header('Content-Type: application/json');
		echo json_encode($messageIfDeleted, true);
	} catch (Exception $e) {
		http_response_code(400);
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
	}
}
?>