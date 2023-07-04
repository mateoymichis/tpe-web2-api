<?php

require_once "./model/MarcasModel.php";
require_once "./view/JSONView.php";
require_once "./helper/AuthHelper.php";

class MarcasApiController {
    private $model;
    private $view;
    private $data;
    private $authHelper;

    public function __construct()
    {
        $this->model = new MarcasModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
        $this->authHelper = new AuthHelper();
    }

    public function getData()
    {
        return json_decode($this->data);
    }

    public function esAdmin()
    {
        if (!($this->authHelper->validarPermisos())) {
            $this->view->response("No tiene autorización para realizar esta acción", 401);
            die();
        }
    }

    public function getMarcas($params = null)
    {
        $marcas = $this->model->getMarcas();
        $this->view->response($marcas, 200);

    }

    public function getMarca($params = null)
    {
        // obtiene el parametro de la ruta
        $id = $params[':ID'];

        $marca = $this->model->getMarca($id);
        if ($marca) {
            $this->view->response($marca, 200);
        } else {
            $this->view->response("No existe la marca con el id={$id}", 404);
        }

    }

    public function borrarMarca($params = null)
    {
        $this->esAdmin();
        $id = $params[':ID'];
        $marca = $this->model->getMarca($id);

        if ($marca) {
            $this->model->borrarMarca($id);
            $this->view->response("Marca id:{$id} eliminada con éxito", 200);
        } else {
            $this->view->response("No existe la marca con el id={$id}", 404);
        }
    }

    public function crearMarca($params = null)
    {
        $this->esAdmin();
        $body = $this->getData();
        $nombre = $body->nombre;
        if($this->model->getMarcaByName($nombre)) {
            $this->view->response("Esa marca ya existe", 404);
            die();
        }
        $cuit = $body->cuit;
        if(!is_numeric($cuit)) {
            $this->view->response("El CUIT debe ser un numero", 404);
            die();
        }
        $id = $this->model->crearMarca($nombre, $cuit);
        $marca = $this->model->getMarca($id);

        if ($marca) {
            $this->view->response("Marca creada con éxito", 201);
        } else {
            $this->view->response("No se pudo crear la marca", 404);
        }
    }

    public function editarMarca($params = null)
    {
        $this->esAdmin();
        $id = $params[':ID'];
        $marca = $this->model->getMarca($id);
        if ($marca) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $cuit = $body->cuit;
            $this->model->editarMarca($nombre, $cuit, $id);
            $this->view->response("Marca id:{$id} actualizada con éxito", 200);
        } else {
            $this->view->response("Marca id:{$id} no encontrada", 404);
        }
    }
}

