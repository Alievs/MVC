<?php

class Model {

    protected $db = null;

    public function __construct() {
        $this->db = DataBase::connect();
    }

}
