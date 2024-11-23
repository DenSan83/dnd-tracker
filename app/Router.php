<?php

namespace app;

use app\Controllers\Controller;
use Exception;


class Router
{
    private $routes = [
        'login' => 'CharacterController::login',
        'logout' => 'CharacterController::logout',
    ];

    public function renderController(string $request)
    {
        $parameters = explode('/',$request);
        $route = $parameters[0];
        $routeStr = $this->getRoute($route);
        if ($routeStr) {
            $request = explode('::', $routeStr);
            [$controllerName, $method] = $request;

            unset($parameters[0], $_GET['r']);
            $parameters = array_values($parameters);

            try {
                $controller = "app\\Controllers\\$controllerName";
                $currentController = new $controller();
                $currentController->$method($parameters);
            } catch (Exception $e) {
                throw new Exception($e);
            }


        } else {
            $controller = new Controller();
            $controller->redirect('404');
        }
        return 'done';
    }

    public function getRoute($route)
    {
        if (key_exists($route,$this->routes)) {
            return $this->routes[$route];
        }

        return;
    }

    public function globalVars()
    {
        define('HOST', $_ENV['HOST']);
    }

}