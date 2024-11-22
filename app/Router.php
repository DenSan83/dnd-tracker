<?php

namespace app;

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
        if (key_exists($route,$this->routes)) {
            $request = explode('::', $this->routes[$route]);
            [$controllerName, $method] = $request;

            unset($parameters[0]);
            $parameters = array_values($parameters);

            try {
                $controller = "app\\Controllers\\$controllerName";
                $currentController = new $controller();
                $currentController->$method($parameters);
            } catch (Exception $e) {
                throw new Exception($e);
            }


        } else {
            $this->redirect('404');
        }
        return 'done';
    }

}