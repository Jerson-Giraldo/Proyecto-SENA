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
    $cliente = $this->clienteModel->getAll('');
    $res->success = true;
    $res->result = $cliente;
    echo json_encode($res);
  }

  public function edit()
  {
    $id = $_GET['id'] ?? null;
    $cliente = $this->clienteModel->getById($id);
    $this->render('clienteNew', [
      'cliente' => $cliente,
    ], 'site');
  }

  public function create()
  {
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode($postData, true);
    $this->clienteModel->insert([
      'nombre' => $body['nombre'],
      'domicilio' => $body['domicilio'],
      'telefono' => $body['telefono'],
      'cumpleanos' => $body['cumpleanos'],

    ]);
    $res->success = true;
    $res->message = "El registro fue insertado correctamente";
    echo json_encode($res);
  }

  public function update()
  {
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode($postData, true);
    $this->clienteModel->updateById($body['id'], [
      'nombre' => $body['nombre'],
      'domicilio' => $body['domicilio'],
      'telefono' => $body['telefono'],
      'cumpleaños' => $body['cumpleanos'],
    ]);
    $res->success = true;
    $res->message = "El registro fue actualizado correctamente";
    echo json_encode($res);
  }

  public function delete()
  {
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode($postData, true);
    $this->clienteModel->deleteById($body['id']);

    $res->success = true;
    $res->message = "El registro fue eliminado correctamente";
    echo json_encode($res);
  }

  public function validateInput()
  {
  }
}
