<?php

use app\Router;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$path = (isset($_GET['r'])) ? $_GET['r'] : 'home';
$router = new Router();
$router->renderController($path);