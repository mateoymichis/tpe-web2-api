<?php
require_once('./libs/Router.php');
require_once('./controller/CelularesApiController.php');
require_once('./controller/UsuariosApiController.php');
require_once('./controller/MarcasApiController.php');
    
// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas
$router->addRoute("celulares", "GET", "CelularesApiController", "getCelulares");
$router->addRoute("celulares/:ID", "GET", "CelularesApiController", "getDetalleCelular");
$router->addRoute("celulares/:ID", "DELETE", "CelularesApiController", "borrarCelular");
$router->addRoute("celulares", "POST", "CelularesApiController", "crearCelular");
$router->addRoute("celulares/:ID", "PUT", "CelularesApiController", "editarCelular");

$router->addRoute('login', 'POST', 'UsuariosApiController', 'login');

$router->addRoute('usuario', 'POST', 'UsuariosApiController', 'crearUsuario');

$router->addRoute('marcas', 'GET', 'MarcasApiController', 'getMarcas');
$router->addRoute('marcas/:ID', 'GET', 'MarcasApiController', 'getMarca');
$router->addRoute('marcas/:ID', 'DELETE', 'MarcasApiController', 'borrarMarca');
$router->addRoute('marcas', 'POST', 'MarcasApiController', 'crearMarca');
$router->addRoute('marcas/:ID', 'PUT', 'MarcasApiController', 'editarMarca');

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
