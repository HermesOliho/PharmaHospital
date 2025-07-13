<?php

$debut_app = microtime(true);

use HeromTech\Dispatcher;

require_once "../vendor/autoload.php";

define("WEB_ROOT", dirname(__FILE__));
define("ROOT", dirname(WEB_ROOT));
define("DS", DIRECTORY_SEPARATOR);
define("BASE_URL", $_SERVER['HTTP_HOST']);

// Démarrer la session
session_start();

require ROOT . DS . "functions" . DS . "dev.php";
require ROOT . DS . "config" . DS . "conf.php";

// Autoriser les applications externes
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,HEADERS,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
// header("Content-Type: application/json; charset=UTF-8");

// Initialisation
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Lancer l'application
$dispatcher = new Dispatcher();
