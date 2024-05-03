<?php
/**Este ORM nos va a permitir hacer consultas y transacciones en la base de datos.
 en este ORM debo crear una clase por cada tabla que tenga en la base de datos, estas clases van a heredar de la clase ORM
 todos los métodos que esten en la clase ORM
*/
class Orm
{
  protected $id;// Esta propiedad va hacer para almacenar el identificador de la tabla
  protected $table;// Esta propiedad va hacer para almacenar el nombre de la tabla
  protected $db;// Esta propiedad va hacer para almacenar la conección de la base de datos para realizar consultas y transacciones

  public function __construct($id, $table, PDO $coneccion)
  {
    $this->id = $id;
    $this->table = $table;
    $this->db = $coneccion;
  }

  public function getAll($id) //Para traer todos los registros de una tabla.
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function deleteById($id)
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
    $stmt->bindValue("id", $id);
    $stmt->execute();
  }

  public function updateById($id, $data) //El párametro data nos sirve para pasar toda la información que queremos actualizar
  {
    $sql = "UPDATE {$this->table} SET";
    foreach ($data as $key => $value) {
      $sql .= "{$key} = :{$key},";
    }
    $sql = trim($sql, ',');
    $sql .= " WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    foreach ($data as $key => $value) {
    }
    $stmt->bindValue(":{$key}", $value);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
  }

  public function insert($data)
  {
    $sql = "INSERT INTO {$this->table} (";
    foreach ($data as $key => $value) {
      $sql .= "{$key},";
    }
    $sql = trim($sql, ',');
    $sql .= ") VALUES(";
    foreach ($data as $key => $value) {
      $sql .= ":{$key},";
    }
    $sql .= ")";

    $stmt = $this->db->prepare($sql);
    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }
    $stmt->execute();
  }

  public function paginate($page, $limit)
  {
    $offset = ($page - 1) * $limit;
    $rows = $this->db->query("SELECT COUNT(*) FROM {$this->table} ")->fetchColumn();
    $sql = "SELECT * FROM {$this->table} LIMIT {$offset}, {$limit}";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $pages = ceil($rows / $limit);
    $data = $stmt->fetchAll();
    return [
      'data' => $data,
      'page' => $page,
      'limit' => $limit,
      'pages' => $pages,
      'rows' => $limit
    ];
  }
}
