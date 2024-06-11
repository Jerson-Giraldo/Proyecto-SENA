<?php
require_once(__DIR__ . '/../Models/usuario.php');
class UsuarioController extends Controller
{
  private $usuarioModel;
  public function __construct(PDO $coneccion)
  {
    $this->usuarioModel = new Usuario($coneccion);
  }

  public function home()
  {
    $this->render('registrarse', [], 'site');
  }
}
