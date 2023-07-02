<?php 

require_once './model/UsuariosModel.php';
require_once './view/JSONView.php';
require_once './helper/AuthHelper.php';

class UsuariosApiController {
    private $view;
    private $model;
    private $authHelper;
    private $data;

    public function __construct() {
        $this->data = file_get_contents("php://input");
        $this->view = new JSONView();
        $this->model = new UsuariosModel();
        $this->authHelper = new AuthHelper();
    }

    public function getData()
    {
        return json_decode($this->data);
    }

    public function login() {
        $datos = $this->getData();
        $usuario = $datos->email;
        $pass = $datos->password;
        if(empty($usuario) || empty($pass)) {
            return $this->view->response("Debe indicar el email y la contraseña del usuario", 400);
        }
        $usuario = $this->model->getByEmail($usuario);
        if($usuario  && password_verify($pass, $usuario->password)) {
            $token = $this->authHelper->getToken($usuario);
            $this->view->response($token, 200);
        } else {
            $this->view->response("Email o contraseña incorrecta", 400);
        }
    }

}