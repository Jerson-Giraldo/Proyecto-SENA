<?php
class Router
{
    private $controller;
    private $method;
    private $params = [];

    public function __construct()
    {
        $this->matchRouter();
    }

    public function matchRouter()
    {
        $url = explode('/', URL);
        $this->controller = !empty($url[1]) ? $url[1] : 'Page';
        $this->method = !empty($url[2]) ? $url[2] : 'home';
        $this->params = array_slice($url, 3);

        $this->controller = ucfirst($this->controller);
        $controllerFile = __DIR__ . '/Controllers/' . $this->controller . 'Controller.php';

        if (file_exists($controllerFile)) {
            require_once($controllerFile);

            $database = new Database();
            $connection = $database->getConnection();

            $controllerClass = $this->controller . 'Controller';

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass($connection, $this->params[0] ?? 'default');
                $method = $this->method;

                if (method_exists($controller, $method)) {
                    $controller->$method();
                } else {
                    switch ($method) {
                        case 'new':
                        case 'table':    
                        case 'edit':
                        case 'create':
                        case 'update':
                        case 'delete':
                        case 'structure':    
                            $controller->$method();
                            break;
                        default:
                            echo "Método {$method} no encontrado en el controlador {$this->controller}.";
                            break;
                    }
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
