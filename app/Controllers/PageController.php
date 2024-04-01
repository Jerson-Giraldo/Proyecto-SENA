<?php

class PageController extends Controller
{
  public function __construct(PDO $coneccion)
  {

  }
  
  public function home()
  {
    // echo 'Estoy en home';
    // require_once (__DIR__ . '/../Views/home.view.php');
    $this->render('home', [],'site');
  }
  
  public function listar()
  {
    // echo 'Estoy en listar';
    // require_once (__DIR__ . '/../Views/listar.view.php');
    $this->render('listar', [],'site');
  }

  public function modificar()
  {
    // echo 'Estoy en modificar';
    // require_once (__DIR__ . '/../Views/modificar.view.php');
    $this->render('modificar', [],'site');
  }

  public function nuevo()
  {
    // echo 'Estoy en nuevo';
    // require_once (__DIR__ . '/../Views/nuevo.view.php');
    $this->render('nuevo', [],'site');
  }

  public function eliminar()
  {
    // echo 'Estoy en eliminar';
    // require_once (__DIR__ . '/../Views/eliminar.view.php');
    $this->render('eliminar', [],'site');
  }
}
