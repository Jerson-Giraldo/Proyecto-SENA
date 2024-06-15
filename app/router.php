<?php
class Router
{
    private $controller;
    private $method;

    public function __construct()
    {
        $this->matchRouter();
    }

    public function matchRouter()
    {
        $url = explode('/', URL);
        $this->controller = !empty($url[1]) ? $url[1] : 'Page';
        $this->method = !empty($url[2]) ? $url[2] : 'home';
        $this->controller = ucfirst($this->controller); // Mantener el nombre del controlador como viene en la URL
        $controllerFile = __DIR__ . '/Controllers/' . $this->controller . 'Controller.php';

        if (file_exists($controllerFile)) {
            require_once($controllerFile);

            $database = new Database();
            $connection = $database->getConnection();

            $controllerClass = $this->controller . 'Controller'; // Asegurarse de usar el nombre correcto

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass($connection, strtolower($this->controller));
                $method = $this->method;

                if (method_exists($controller, $method)) {
                    $controller->$method();
                } else {
                    echo "Método {$method} no encontrado en el controlador {$this->controller}.";
                }
            } else {
                echo "Clase {$controllerClass} no encontrada.";
            }
        } else {
            echo "Controlador {$this->controller} no encontrado.";
        }
    }

    public function run()
    {
        $this->matchRouter();
    }
}
