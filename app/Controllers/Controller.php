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

    public function redirect($route, $params = '')
    {
        $router = new Router();
        if (!$router->getRoute($route)) {
            $route = '';
        }

        if (!empty($sessionMessage)) $_SESSION['return'] = $sessionMessage;
        if (!empty($params)) $params = '?'.$params;
        header('Location: '. HOST . '/' . $route . $params);
        exit;
    }

}