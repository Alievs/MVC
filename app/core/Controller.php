<?php

class Controller {

    public $model;
    public $view;
    protected $pageData = array(); //array for dynamic data in view

    public function __construct()
    {
        $this->view = new View();
        //контроллеру не нужно подкючение к базе
//        $this->model = new Model();
    }

}