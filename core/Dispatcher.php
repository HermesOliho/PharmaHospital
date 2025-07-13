<?php

namespace HeromTech;

class Dispatcher
{
    var Request $request;
    var Controller $controller;

    public function __construct()
    {
        $this->request = new Request();
        // Router::parse($this->request);
        if (Router::parse($this->request)) {
            $this->controller = $this->loadController();
            $controller_methods = array_diff(
                get_class_methods($this->controller),
                get_class_methods(get_parent_class($this->controller))
            );
            if (! in_array($this->request->action, $controller_methods)) {
                $controller_class = get_class($this->controller);
                $controller_class = str_replace("Controllers\\", "", $controller_class);
                $this->error("La classe {$controller_class} n'a pas de méthode '{$this->request->action}' !");
            } else {
                call_user_func_array(
                    array($this->controller, $this->request->action),
                    $this->request->params
                );
            }
        }
    }

    public function error(string $message, int $http_code = 404)
    {
        http_response_code($http_code);
        $this->controller->set("message", $message);
        $this->controller->render("/errors/404");
    }

    public function loadController()
    {
        $name = "Controllers\\" . ucfirst($this->request->controller) . 'Controller';
        if (!class_exists($name)) {
            $this->controller = new Controller($this->request);
            $this->error("Le contrôleur {$this->request->controller} n'existe pas !");
            exit;
        } else {
            return new $name($this->request);
        }
    }
}
