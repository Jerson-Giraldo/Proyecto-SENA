<?php
require_once(__DIR__ . '/../Models/cliente.php');/*Esta linea importa la definición de la calse cliente desde el archivo cliente.php
que se encuentra en el directorio Models,asi que, 
la clase Cliente es un modelo que interactua con la base de datos utilizando la clase ORM */

class ClienteController extends Controller
{
  private $clienteModel;
  public function __construct(PDO $coneccion)
  {
    $this->clienteModel = new Cliente($coneccion);
  }

  public function home()
  {
    $this->render('cliente', [], 'site');/*Con la función render estoy mostrando la vista cliente, 
    [] con este array puedo pasar datos adicionales a la vista, en este caso no se estan pasando datos a la vista,
    con el site indico el contexto o el área del sitio en el que se renderizará la vista*/
  }

  public function new()
  {
    $this->render('clienteNew', [], 'site');
  }

  public function table()
  {
    $res = new Result();//instanciación del objeto $res
    $cliente = $this->clienteModel->getAll('');/*En la variable $cliente se almacena los registros de la consulta que se hace con getAll
    y getAll se invoca con la propiedad clienteModel. La función getAll está en el archivo ORM, ahi encontramos las consultas en código sql*/
    $res->success = true;/*Aqui por medio del objeto $res accedemos a las propiedades success y result de la clase Result()*/
    $res->result = $cliente;
    echo json_encode($res);/*Aqui el resultado de la consulta a la base de datos se asigna a la propiedad result  del objeto $res
    que se convierte en formato JSON y se imprime en la salida*/
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
