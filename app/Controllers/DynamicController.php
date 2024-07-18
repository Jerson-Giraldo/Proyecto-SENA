<?php
require_once(__DIR__ . '/../Models/DynamicModel.php');

class DynamicController extends Controller
{
    private $model;
    private $tableName; // Variable para almacenar el nombre de la tabla

    public function __construct(PDO $coneccion, string $tableName, string $idColumn = 'id')
    {
        $this->model = new Orm($tableName, $idColumn, $coneccion);
        $this->tableName = $tableName; // Asignar el nombre de la tabla a la propiedad
    
    }

    public function home()
    {
        $this->render('table', ['tableName' => $this->tableName], 'site');
    }

    public function new()
    {
        $this->render('formNew', ['tableName' => $this->tableName], 'site');
    }

    public function table()
    {
        $res = new Result();
        $items = $this->model->getAll();
    
        $res->success = true;
        $res->result = $items;
    
        header('Content-Type: application/json');
        echo json_encode($res);
        exit; 
    }
    


    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $item = $this->model->getById($id);

        $this->render('formNew', ['tableName' => $this->tableName, 'item' => $item], 'site');
    }

    public function create()
{
    $res = new Result();
    
    try {
        // Obtener los datos del cuerpo de la solicitud POST
        $postData = file_get_contents('php://input');
        $body = json_decode($postData, true);
        var_dump($body);
        // Verificar que los datos sean un array válido
        if (!is_array($body) || empty($body)) {
            throw new InvalidArgumentException("Los datos proporcionados para insertar no son válidos.");
        }

        // Insertar los datos usando el modelo Orm
        $this->model->insert($body);

        $res->success = true;
        $res->message = "El registro fue insertado correctamente";
    } catch (InvalidArgumentException $e) {
        $res->success = false;
        $res->message = "Error al insertar el registro: " . $e->getMessage();
    } catch (Exception $e) {
        $res->success = false;
        $res->message = "Error al insertar el registro: " . $e->getMessage();
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($res);
}


    public function update()
    {
        $res = new Result();
        try {
            $postData = file_get_contents('php://input');
            $body = json_decode($postData, true);

            if (!isset($body['id'])) {
                throw new Exception("Datos insuficientes para actualizar el registro");
            }

            $this->model->updateById($body['id'], $body);

            $res->success = true;
            $res->message = "El registro fue actualizado correctamente";
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

        if (!isset($body['id'])) {
            $res->success = false;
            $res->message = "Datos insuficientes para eliminar el registro";
        } else {
            $this->model->deleteById($body['id']);
            $res->success = true;
            $res->message = "El registro fue eliminado correctamente";
        }

        echo json_encode($res);
    }

    public function structure()
{
    $res = new Result();

    try {
        // Obtener la estructura de la tabla
        $columns = $this->model->getTableColumns();

        if (is_array($columns) && !empty($columns)) {
            $res->success = true;
            $res->structure = $columns;
        } else {
            throw new Exception("Error al obtener la estructura de la tabla");
        }
    } catch (Exception $e) {
        $res->success = false;
        $res->message = "Error al obtener la estructura de la tabla: " . $e->getMessage();
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($res);
}



}


