<?php

namespace app\Controllers;

use app\Router;
use app\Views\View;

class Controller
{
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function redirect($route, $routeParams = '', $sessionData = [])
    {
        $router = new Router();
        if (!$router->getRoute($route)) {
            $route = '';
        }

        if (!empty($sessionData)) $_SESSION['return'] = $sessionData;
        $params = '';
        if (!empty($routeParams)) $params = $routeParams;
        header('Location: '. HOST . '/' . $route . $params);
        exit;
    }

    public function error404()
    {
        $this->view->load('error404');
    }

}