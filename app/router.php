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
    $this->controller = $this->controller . 'Controller';
    require_once(__DIR__ . '/Controllers/' . $this->controller . '.php');
  }

  public function run()
  {
    $database = new DataBase();
    $coneccion = $database->getConnection();
    $controller = new $this->controller($coneccion);
    $method = $this->method;
    $controller->$method();
  }
}
