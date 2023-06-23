<?php

require_once "./model/CelularesModel.php";
require_once "./view/JSONView.php";

class CelularesApiController {
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new CelularesModel();
        $this->view = new JSONView();
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

}
