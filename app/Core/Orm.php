<?php
/**Este ORM nos va a permitir hacer consultas y transacciones en la base de datos.
 en este ORM debo crear una clase por cada tabla que tenga en la base de datos, estas clases van a heredar de la clase ORM
 todos los métodos que esten en la clase ORM
 */
class Orm
{
  protected $idColumn; // Almacena el nombre de la columna de identificación
  protected $table; // Almacena el nombre de la tabla
  protected $db; // Almacena la conexión de la base de datos

  public function __construct($table, $idColumn = 'id', PDO $connection)
  {
    $this->table = $table;
    $this->idColumn = $idColumn;
    $this->db = $connection;
  }

  public function getAll()
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->idColumn} = :id");
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function deleteById($id)
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->idColumn} = :id");
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function updateById($id, $data)
  {
    $sql = "UPDATE {$this->table} SET ";
    foreach ($data as $key => $value) {
      $sql .= "{$key} = :{$key}, ";
    }
    $sql = rtrim($sql, ', ') . " WHERE {$this->idColumn} = :id";

    $stmt = $this->db->prepare($sql);

    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function insert($data)
{
    if (!is_array($data) || empty($data)) {
        throw new InvalidArgumentException('Los datos proporcionados para insertar no son válidos.');
    }

    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
    $stmt = $this->db->prepare($sql);

    foreach ($data as $key => $value) {
        $stmt->bindValue(":{$key}", $value);
    }

    $stmt->execute();
}

  public function paginate($page, $limit)
  {
    $offset = ($page - 1) * $limit;
    $rows = $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    $sql = "SELECT * FROM {$this->table} LIMIT :offset, :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $pages = ceil($rows / $limit);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
      'data' => $data,
      'page' => $page,
      'limit' => $limit,
      'pages' => $pages,
      'rows' => $rows
    ];
  }

  public function getTableColumns()
  {
      $stmt = $this->db->prepare("DESCRIBE {$this->table}");
      $stmt->execute();
      
      // Generar información de depuración o errores
      $debugOutput = ""; // Inicializa con cadena vacía o algo específico si hay datos
  
      // Ejemplo: Capturar mensajes de error
      while ($error = $stmt->errorInfo()) {
          $debugOutput .= "SQLSTATE: {$error[0]} - Error code: {$error[1]} - Error message: {$error[2]}\n";
      }
  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
