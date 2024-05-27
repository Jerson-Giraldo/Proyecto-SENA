<?php
class Router
{
  //Estas dos propiedades me sirven para saber que controlador estoy invocando y que método estoy invocando
  private $controller;
  private $method;

  public function __construct()
  {
    $this->matchRouter(); //Invocando el método matchRouter
  }

  public function matchRouter()
  {
    $url = explode('/', URL);
    /**Esta función me separa una cadena de texto por medio de un separador '/' y 
    como segundo párametro se coloca la constante global URL que se escribió en el archivo config.php*/
    //Luego asignamos el controlador y el método
    $this->controller = !empty($url[1]) ? $url[1] : 'Page'; //El controlador se encuentra en la posición 1 de la variable $url y si esta vacio el controlador por defecto es page
    $this->method = !empty($url[2]) ? $url[2] : 'home'; //El método se encuentra en la posición 2 de la variable $url y si esta vacio el método por defecto es home
    $this->controller = $this->controller . 'Controller'; //hay que recordar de contoller vale en este caso page y se concatena con controller y su valor final es pageController
    require_once(__DIR__ . '/Controllers/' . $this->controller . '.php'); //Requiriendo el archivo pageController colocando $this->controller que vale pageController
  }

  //El método run es el encargado de ejecutar el router
  public function run()
  {
    $database = new DataBase();
    $coneccion = $database->getConnection();
    $controller = new $this->controller($coneccion); //instanciamos
    $method = $this->method; //almacenando el método $this->method en la variable $method que se encuentra actualmente en la propiedad $this->method  
    /**Ejecutar el método en la instancia $controller = new $this->controller($coneccion) */
    $controller->$method();
  }
}
