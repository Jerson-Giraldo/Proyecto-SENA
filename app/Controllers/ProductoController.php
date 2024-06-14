<?php
require_once(__DIR__ . '/../Models/producto.php');/*Esta linea importa la definición de la calse cliente desde el archivo cliente.php
que se encuentra en el directorio Models,asi que, 
la clase Cliente es un modelo que interactua con la base de datos utilizando la clase ORM */

class ProductoController extends Controller
{
  private $productoModel;
  public function __construct(PDO $coneccion)
  {
    $this->productoModel = new Producto($coneccion);
  }

  public function home()
  {
    $this->render('producto', [], 'site');/*Con la función render estoy mostrando la vista producto, 
    [] con este array puedo pasar datos adicionales a la vista, en este caso no se estan pasando datos a la vista,
    con el site indico el contexto o el área del sitio en el que se renderizará la vista*/
  }

  public function new()
  {
    $this->render('productoNew', [], 'site');
  }

  public function table() /*Con esta función imprimimos la tabla de la base de datos en formato JSON*/
  {
    $res = new Result(); //instanciación del objeto $res
    $producto = $this->productoModel->getAll('');/*En la variable $producto se almacena los registros de la consulta que se hace con getAll
    y getAll se invoca con la propiedad productoModel. La función getAll está en el archivo ORM, ahi encontramos las consultas en código sql*/
    $res->success = true;/*Aqui por medio del objeto $res accedemos a las propiedades success y result de la clase Result()*/
    $res->result = $producto;
    echo json_encode($res);/*Aqui el resultado de la consulta a la base de datos se asigna a la propiedad result  del objeto $res
    que se convierte en formato JSON y se imprime en la salida*/
  }

  public function edit() //Esta función se encarga de mostrar la vista para editar los detalles de un cliente específico.
  {
    $id = $_GET['idproducto'] ?? null;/*Obtiene el parámetro id de la URL a través de $_GET['id'].El operador ?? null se utiliza para
    establecer id como nulo si no se proporciona ningún valor en la URL*/
    $producto = $this->productoModel->getById($id, 'idproducto');/*utiliza el método getById() del modelo de producto ($this->productoModel)
    para obtener los detalles correspondiente al id proporcionado. NOTA: el modelo producto hereda los métodos del ORM*/
    $this->render('productoNew', ['producto' => $producto,], 'site'); /*Llama al método render para renderizar la vista de edición (productoNew) se pasa un arreglo asociativo que contiene los detalles del producto bajo la clave producto, el tercer parámetro que es site, indica el contexto o área del sitio en el que se renderizará la vista.*/
  }

  public function create()
  {
    $res = new Result();/*Se crea un nuevo objeto de la clase Result. Esta clase se utiliza para estructurar 
    la respuesta que se enviará al cliente.*/
    $postData = file_get_contents('php://input'); //Con esta función traemos la información que enviamos de javascript
    $body = json_decode($postData, true);

    $this->productoModel->insert([
      'nombre' => $body['nombre'],
      'tipo_producto' => $body['tipo_producto'],
      'ubicacion' => $body['ubicacion'],
      'cantidad_stock' => $body['cantidad_stock'],
      'codigo_barras' => $body['codigo_barras'],
      'lote' => $body['lote'],
      'fecha_ingreso' => $body['fecha_ingreso'],
      'fecha_salida' => $body['fecha_salida'],
      'precio' => $body['precio'],
      'detalles_de_factura_iddetalles_de_factura' => $body['detalles_de_factura_iddetalles_de_factura'],
      'comentarios_producto' => $body['comentarios_producto'],
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

      if (isset($body['idproducto'], $body['nombre'], $body['tipo_producto'], $body['ubicacion'], $body['cantidad_stock'], $body['codigo_barras'], $body['lote'], $body['fecha_ingreso'], $body['fecha_salida'], $body['precio'], $body['detalles_de_factura_iddetalles_de_factura'], $body['comentarios_producto'])) {
        $this->productoModel->updateById($body['idproducto'], [
          'nombre' => $body['nombre'],
          'tipo_producto' => $body['tipo_producto'],
          'ubicacion' => $body['ubicacion'],
          'cantidad_stock' => $body['cantidad_stock'],
          'codigo_barras' => $body['codigo_barras'],
          'lote' => $body['lote'],
          'fecha_ingreso' => $body['fecha_ingreso'],
          'fecha_salida' => $body['fecha_salida'],
          'precio' => $body['precio'],
          'detalles_de_factura_iddetalles_de_factura' => $body['detalles_de_factura_iddetalles_de_factura'],
          'comentarios_producto' => $body['comentarios_producto'],
        ], 'idproducto'); // Especificando 'idproducto' como columna de identificación
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
    $this->productoModel->deleteById($body['idproducto'], 'idproducto'); // Especificando 'idproducto' como columna de identificación

    $res->success = true;
    $res->message = "El registro fue eliminado correctamente";
    echo json_encode($res);
  }

  public function structure()
  {
    $res = new Result(); // Crear una instancia del objeto Resultado

    try {
      $columns = $this->productoModel->getTableColumns(); // Obtener las columnas de la tabla

      if (is_array($columns)) {
        $res->success = true;
        $res->structure = $columns; // Asignar las columnas al atributo 'structure'
      } else {
        throw new Exception("La función getTableColumns() no devolvió un array válido.");
      }
    } catch (Exception $e) {
      $res->success = false;
      $res->message = "Error al obtener la estructura de la tabla: " . $e->getMessage();
    }

    // Establecer la cabecera Content-Type para JSON
    header('Content-Type: application/json');

    // Codificar el objeto $res como JSON y mostrarlo
    echo json_encode($res);
  }
}
