<?php
require_once('./libs/Router.php');
require_once('./controller/CelularesApiController.php');
    
// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas
$router->addRoute("celulares", "GET", "CelularesApiController", "getCelulares");

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
