<?php
require_once(__DIR__ . '/../Models/cliente.php');

class ClienteController extends Controller
{
  private $clienteModel;
  public function __construct(PDO $coneccion)
  {
    $this->clienteModel = new Cliente($coneccion);
  }

  public function home()
  {
    $this->render('cliente', [], 'site');
  }

  public function new()
  {
  }

  public function table()
  {
    $res = new Result();
    $clientes = $this->clienteModel->getAll('');
    $res->success = true;
    $res->result = $clientes;
    echo json_encode($res);
  }

  public function edit()
  {
  }

  public function create()
  {
  }

  public function update()
  {
  }

  public function delete()
  {
  }

  public function validateInput()
  {
  }
}
