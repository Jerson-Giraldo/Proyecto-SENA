<?php
require_once(__DIR__ . '/../Models/producto.php');

class DynamicController extends Controller
{
    private $model;
    private $tableName; // Variable para almacenar el nombre de la tabla

    public function __construct(PDO $coneccion, string $tableName, string $idColumn = 'id')
    {
        $this->model = new Orm($tableName, $idColumn, $coneccion);
        $this->tableName = $tableName; // Asignar el nombre de la tabla a la propiedad
        // Depuración
        echo "Table Name: " . $this->tableName . "<br>";
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

        echo json_encode($res);
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
        $postData = file_get_contents('php://input');
        $body = json_decode($postData, true);

        $this->model->insert($body);

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
            $columns = $this->model->getTableColumns();

            if (is_array($columns)) {
                $res->success = true;
                $res->structure = $columns;
            } else {
                throw new Exception("Error al obtener la estructura de la tabla");
            }
        } catch (Exception $e) {
            $res->success = false;
            $res->message = "Error al obtener la estructura de la tabla: " . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($res);
    }
}


