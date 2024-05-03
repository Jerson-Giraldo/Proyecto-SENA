<?php

class PageController extends Controller
{
  public function __construct(PDO $coneccion)
  {

  }
  
  public function home()
  {
    $this->render('home', [],'site');
  }
  
  public function listar()
  {
    $this->render('listar', [],'site');
  }

  public function modificar()
  {
    $this->render('modificar', [],'site');
  }

  public function nuevo()
  {
    $this->render('nuevo', [],'site');
  }

  public function eliminar()
  {
    $this->render('eliminar', [],'site');
  }
}
/**La ruta URL va a ser de la siguiente manera: http://localhost/page/listar
page y listar son los párametros, page va a llamar al controlador que seria la clase y listar llamaria al método.
El router va a ser un intermediario entre los párametros de la ruta y el controlador. 
osea procesa los párametros de la URL llama al controlador que es la clase y al método**/
