<?php
//настройки конфигурации
ini_set('display_errors', 1);

session_start();

define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("CONTROLLER_PATH", ROOT. "/app/controllers/");
define("MODEL_PATH", ROOT. "/app/models/");
define("VIEW_PATH", ROOT. "/app/views/");
define("CORE_PATH", ROOT. "/app/core/");

require_once CORE_PATH . 'DataBase.php';
require_once CORE_PATH ."Route.php";
require_once CORE_PATH ."Model.php";
require_once CORE_PATH ."View.php";
require_once CORE_PATH ."Controller.php";

Route::buildRoute();