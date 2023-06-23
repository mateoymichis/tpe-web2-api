<?php

require_once "./model/CelularesModel.php";
require_once "./view/JSONView.php";

class CelularesApiController {
    private $model;
    private $view;
    private $data;

    public function __construct()
    {
        $this->model = new CelularesModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    public function getData() {
        return json_decode($this->data);
    }

    public function getCelulares($params = null) {
        $celulares = $this->model->getCelulares();
        $this->view->response($celulares, 200);
    }

    public function getDetalleCelular($params = null) {
        // obtiene el parametro de la ruta
        $id = $params[':ID'];
        
        $celular = $this->model->getDetalleCelular($id);
        
        if ($celular) {
            $this->view->response($celular, 200);
        } else {
            $this->view->response("No existe el celular con el id={$id}", 404);
        }
    }

    public function borrarCelular($params = null) {
        $id = $params[':ID'];
        $celular = $this->model->getDetalleCelular($id);

        if ($celular) {
            $this->view->response("Celular id:{$id} eliminado con éxito", 200);
        } else {
            $this->view->response("No existe el celular con el id={$id}", 404);
        }
    }

    public function crearCelular($params = null) {
        $body = $this->getData();
        //modelo, descripcion, imagen, marca_id
        $modelo = $body->modelo;
        $descripcion = $body->descripcion;
        $imagen = $body->imagen;
        $marca_id = $body->marca_id;
        $id = $this->model->crearCelular($modelo, $descripcion, $imagen, $marca_id);
        $celular = $this->model->getDetalleCelular($id);
    
        if($celular) {
            $this->view->response("Celular creado con éxito", 201);
        }
        else {
            $this->view->response("No se pudo crear el celular", 404);
        }
    }

}
