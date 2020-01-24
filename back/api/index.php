<?php
include_once ('./router/possibleRoute.php');
include_once ('env.php');
include_once ('controllers/appointmentController.php');
include_once ('./services/validator/validator.php');
include_once ('./services/helper/helper.php');
header("Access-Control-Allow-Origin: *");

if($ressourcesAsk === ROUTER_APPOINTMENT && $requestMethod === 'GET') {
    listAppointment();
}

if(preg_match(ROUTER_ONE_APPOINTMENT, $ressourcesAsk) && $requestMethod === 'GET') {
    $idToSearch = ltrim($ressourcesAsk, '/appointment/');
    oneAppointment($idToSearch);
}

if(preg_match(ROUTER_ONE_APPOINTMENT, $ressourcesAsk) && $requestMethod === 'PUT') {
    $idToSearch = ltrim($ressourcesAsk, '/appointment/');
    updateAppointment($idToSearch, $_POST['dateAppointment']);
}

if(preg_match(ROUTER_ONE_APPOINTMENT, $ressourcesAsk) && $requestMethod === 'DELETE') {
    $idToDelete = ltrim($ressourcesAsk, '/appointment/');
    deleteAppointment($idToDelete);
}

if($ressourcesAsk === ROUTER_APPOINTMENT && $requestMethod === 'POST') {
    postAppointment($_POST['dateAppointment'], $_POST['nomUser'], $_POST['prenomUser'], $_POST['emailUser'], $_POST['telephoneUser']);
}
?>