<?php
require_once(__DIR__ . '/../Models/DynamicModel.php');

class DynamicController extends Controller
{
    private $model;
    private $tableName;

    public function __construct(PDO $connection, string $tableName, string $idColumn = 'id')
    {
        $this->model = new DynamicModel($connection, $tableName, $idColumn);
        $this->tableName = $tableName;
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
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 100;
    
        try {
            $pagination = $this->model->paginate($page, $limit);
            $res->success = true;
            $res->result = $pagination['data'];
            $res->page = $pagination['page'];
            $res->limit = $pagination['limit'];
            $res->pages = $pagination['pages'];
            $res->rows = $pagination['rows'];
        } catch (Exception $e) {
            $res->success = false;
            $res->message = "Error al obtener los datos: " . $e->getMessage();
        }
    
        header('Content-Type: application/json');
        echo json_encode($res);
        exit;
    }

    public function create()
    {
        $res = new Result();

        try {
            $postData = file_get_contents('php://input');
            $body = json_decode($postData, true);

            if (!is_array($body) || empty($body)) {
                throw new InvalidArgumentException("Los datos proporcionados para insertar no son válidos.");
            }

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

    public function getStructure()
{
    $res = new Result();

    try {
        $structure = $this->model->getTableStructure();
        $res->success = true;
        $res->structure = $structure;
    } catch (Exception $e) {
        $res->success = false;
        $res->message = "Error al obtener la estructura de la tabla: " . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($res);
    exit();
}
}
