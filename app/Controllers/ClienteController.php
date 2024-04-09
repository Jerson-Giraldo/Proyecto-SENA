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
    $this->render('clienteNew', [], 'site');
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
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode('postData', true);
    $this->clienteModel->insert([
      'nombre' => $body['nombre'],
      'domicilio' => $body['domicilio'],
      'telefono' => $body['telefono'],
      'cumpleaños' => $body['cumpleaños'],

    ]);
    $res->success = true;
    $res->message = "El registro fue insertado correctamente";
    echo json_encode($res);
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
