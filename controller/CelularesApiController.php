<?php

require_once "./model/CelularesModel.php";
require_once "./view/JSONView.php";
require_once "./helper/whiteList.php";
require_once "./helper/AuthHelper.php";

class CelularesApiController
{
    private $model;
    private $view;
    private $data;
    private $paramsHelper;
    private $authHelper;

    public function __construct()
    {
        $this->model = new CelularesModel();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
        $this->paramsHelper = new WhiteList();
        $this->authHelper = new AuthHelper();
    }

    public function getData()
    {
        return json_decode($this->data);
    }

    public function esAdmin() {
        if(!($this->authHelper->validarPermisos())) {
            $this->view->response("No tiene autorización para realizar esta acción", 401);
            die();
        }
    }

    public function getCelulares($params = null)
    {
        try {
            $direction = $this->setParam(
                'direction',
                ["asc", "desc"],
                'Nombre de dirección incorrecta',
                'ASC'
            );
            $order = $this->setParam(
                'order',
                ["id", "modelo", "descripcion", "imagen", "marca"],
                'Nombre de campo incorrecto',
                'id'
            );
            $filter = $this->setParam(
            'filter', ["modelo", "descripcion", "imagen", "marca"],
            'Nombre de filtro incorrecto',
            'modelo'
            );
            if($filter == 'marca') {
                $filter = 'm.nombre';
            }
            if (isset($_REQUEST['value'])) {
                $value = "%{$_REQUEST['value']}%";
            } else {
                $value = '%%';
            }
            $lower = $this->setNumericParam('lower', 0, 1000000, 0);
            $resultsPerPage = $this->setNumericParam('results', 4, 50, 10);
            $celulares = $this->model->getCelulares($order, $direction, $lower, $resultsPerPage, $filter, $value);
            $this->view->response($celulares, 200);
        
        } catch (Exception){}
        
    }

    public function setParam($name, $whiteList, $message, $default)
    {
        if (isset($_REQUEST[$name])) {
            try {
                return $this->paramsHelper->white_list($_REQUEST[$name], $whiteList, $message);
            } catch (Exception $e) {
                $this->view->response($e->getMessage() . ': ' . $_REQUEST[$name], 404);
            }
        } else {
            return $default;
        }
    }

    public function setNumericParam($name, $min, $max, $default)
    {
        if (isset($_REQUEST[$name])) {
            if ($_REQUEST[$name] >= $min && $_REQUEST[$name] <= $max) {
                return $_REQUEST[$name];
            } else {
                return $default;
            }
        } else {
            return $default;
        }
    }


    public function getDetalleCelular($params = null)
    {
        // obtiene el parametro de la ruta
        $id = $params[':ID'];

        $celular = $this->model->getDetalleCelular($id);

        if ($celular) {
            $this->view->response($celular, 200);
        } else {
            $this->view->response("No existe el celular con el id={$id}", 404);
        }
    }

    public function borrarCelular($params = null)
    {
        $this->esAdmin();
        $id = $params[':ID'];
        $celular = $this->model->getDetalleCelular($id);

        if ($celular) {
            $this->view->response("Celular id:{$id} eliminado con éxito", 200);
        } else {
            $this->view->response("No existe el celular con el id={$id}", 404);
        }
    }

    public function crearCelular($params = null)
    {
        $this->esAdmin();
        $body = $this->getData();
        //modelo, descripcion, imagen, marca_id
        $modelo = $body->modelo;
        $descripcion = $body->descripcion;
        $imagen = $body->imagen;
        $marca_id = $body->marca_id;
        $id = $this->model->crearCelular($modelo, $descripcion, $imagen, $marca_id);
        $celular = $this->model->getCelular($id);

        if ($celular) {
            $this->view->response("Celular creado con éxito", 201);
        } else {
            $this->view->response("No se pudo crear el celular", 404);
        }
    }

    public function editarCelular($params = null)
    {
        $this->esAdmin();
        $id = $params[':ID'];
        $celular = $this->model->getCelular($id);
        if ($celular) {
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
