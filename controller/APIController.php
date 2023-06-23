<?php

abstract class APICOntroller {
    protected $model;
    protected $view;

    private $data;

    public function __construct()
    {
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    public function getData() {
        return json_decode($this->data);
    }
}
