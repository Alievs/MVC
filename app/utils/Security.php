<?php

class Security
{
    public function securityChecker()
    {
        if (!isset($_SESSION['admin'])){
            header('Location:/');
        }
    }
}