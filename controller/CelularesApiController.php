<?php

require_once "./model/CelularesModel.php";
require_once "./view/JSONView.php";
require_once "./helper/whiteList.php";

class CelularesApiController {
    private $model;
    private $view;
    private $data;
    private $helper;

    public function __construct()
    {
        $this->model = new CelularesModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
        $this->helper = new whiteList();
    }

    public function getData() {
        return json_decode($this->data);
    }

    // manejar la excepcion

    public function getCelulares($params = null) {
        if(isset($_REQUEST['order'])) {
            try {
                $order = $this->helper->white_list($_REQUEST['order'],
                ["id", "modelo", "descripcion", "imagen", "marca"],
                "Nombre de campo incorrecto");
            } catch (Exception $e) {
                return $this->view->response($e->getMessage(), 404);
            }
        }
        if(isset($_REQUEST['direction'])) {
            try{
                $direction = $this->helper->white_list($_REQUEST['direction'],
                ["asc", "desc"], "Nombre de dirección incorrecta");
            } catch (Exception $e) {
                return $this->view->response($e->getMessage(), 404);
            }
        } else {
            $direction = '';
        }
        if (isset($order))
        {
            $celulares = $this->model->getCelularesOrderBy($order, $direction);
            $this->view->response($celulares, 200);
        } else {
            $celulares = $this->model->getCelulares();
            $this->view->response($celulares, 200);
        }
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
        $celular = $this->model->getCelular($id);
    
        if($celular) {
            $this->view->response("Celular creado con éxito", 201);
        }
        else {
            $this->view->response("No se pudo crear el celular", 404);
        }
    }

    public function editarCelular($params = null) {
        $id = $params[':ID'];
        $celular = $this->model->getCelular($id);
        if($celular) {
            $body = $this->getData();
            $modelo = $body->modelo;
            $descripcion = $body->descripcion;
            $imagen = $body->imagen;
            $marca_id = $body->marca_id;
            $cel = $this->model->editarCelular($modelo, $descripcion, $imagen, $marca_id, $id);
            $this->view->response("Celular id:{$id} actualizado con éxito", 200);
        } else {
            $this->view->response("Celular id:{$id} no encontrado", 404);
        }
    }
}
