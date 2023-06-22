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
}
