<?php
require_once(__DIR__ . '/../Models/factura.php');
class FacturaController extends Controller
{
  private $facturaModel;
  public function __construct(PDO $coneccion)
  {
    $this->facturaModel = new Factura($coneccion);
  }

  public function home()
  {
    $this->render('factura', [], 'site');
  }

  public function new()
  {
    $this->render('facturaNew', [], 'site');
  }

  public function table() 
  {
    $res = new Result();
    $factura = $this->facturaModel->getAll('');
    $res->success = true;
    $res->result = $factura;
    echo json_encode($res);
  }

  public function edit()
  {
    $id = $_GET['idfactura'] ?? null;
    if ($id) {
      $factura = $this->facturaModel->getById($id, 'idfactura');
      if ($factura) {
        $this->render('facturaNew', ['factura' => $factura], 'site');
      } else {
        // Manejar el caso en que la factura no sea encontrada
        $this->render('error', ['message' => 'Factura no encontrada'], 'site');
      }
    } else {
      // en caso en que el ID no se proporcione
      $this->render('error', ['message' => 'ID de factura no proporcionado'], 'site');
    }
  }

  public function create()
  {
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode($postData, true);

    $this->facturaModel->insert([
      'fecha' => $body['fecha'],
      'cliente_idtable1' => $body['cliente_idtable1'],
      'auxiliar_idusuarios' => $body['auxiliar_idusuarios'],
    ]);
    $res->success = true;
    $res->message = "El registro fue insertado correctamente";
    echo json_encode($res);
  }

  public function update()
  {
    $res = new Result();
    try {
      $postData = file_get_contents('php://input');
      $body = json_decode($postData, true);

      if (isset($body['idfactura'], $body['fecha'], $body['cliente_idtable1'], $body['auxiliar_idusuarios'])) {
        $this->facturaModel->updateById($body['idfactura'], [
          'fecha' => $body['fecha'],
          'cliente_idtable1' => $body['cliente_idtable1'],
          'auxiliar_idusuarios' => $body['auxiliar_idusuarios'],
        ], 'idfactura');// Especificando 'idfactura' como columna de identificación
        $res->success = true;
        $res->message = "El registro fue actualizado correctamente";
      } else {
        $res->success = false;
        $res->message = "Datos insuficientes para actualizar el registro";
      }
    } catch (Exception $e) {
      $res->success = false;
      $res->message = "Error al actualizar el registro: " . $e->getMessage();
    }
    echo json_encode($res);
  }
  public function delete()
  {
    $res = new Result();
    $postData = file_get_contents('php://input');
    $body = json_decode($postData, true);
    $this->facturaModel->deleteById($body['idfactura'], 'idfactura');// Especificando 'idproducto' como columna de identificación

    $res->success = true;
    $res->message = "El registro fue eliminado correctamente";
    echo json_encode($res);
  }
}
