<?php
// variable d'environnement
const BASE_URL = '/raieCreation/back/api/';
const BASE_HOST = 'localhost';
const DB_PORT = '3306';
const DB_NAME = 'raieCreation';
const LOGIN_BDD = 'root';
const MDP_BDD = '';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUrl = $_SERVER['REQUEST_URI'];
$ressourcesAsk = str_replace(BASE_URL, '', $requestUrl);
?>