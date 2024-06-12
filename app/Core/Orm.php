<?php

/**Este ORM nos va a permitir hacer consultas y transacciones en la base de datos.
 en este ORM debo crear una clase por cada tabla que tenga en la base de datos, estas clases van a heredar de la clase ORM
 todos los métodos que esten en la clase ORM
 */
class Orm
{
  protected $id; // Esta propiedad sirve para almacenar el identificador de la tabla
  protected $table; // Esta propiedad va hacer para almacenar el nombre de la tabla
  protected $db; // Esta propiedad va hacer para almacenar la conección de la base de datos para realizar consultas y transacciones

  public function __construct($id, $table, PDO $coneccion)
  {
    $this->id = $id;
    $this->table = $table;
    $this->db = $coneccion;
  }

  public function getAll() //Para traer todos los registros de una tabla sin aplicar ningun filtro
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table}");/*Prepara una consulta SQL utilizando prepare(), 
    donde selecciona todos los campos (*) de la tabla */
    $stmt->execute();/*Ejecuta la consulta utilizando execute() y la consulta se envia al servidor de la base de datos para su ejecución.*/
    return $stmt->fetchAll(PDO::FETCH_ASSOC);/*fetchAll() para recuperar todas las filas resultantes de la ejecución de la consulta y se devuelve como un array.
    Este array contendrá todos los registros seleccionados de la tabla.*/
  }

  public function getById($id, $idColumn = 'id')
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$idColumn} = :id");/*Prepara una consulta sql para seleccionar 
    todos los campos de la tabla donde el id coincida con el valor proporcionado*/
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute(). Esto ejecuta la consulta con el valor del ID proporcionado.*/
    return $stmt->fetch(PDO::FETCH_ASSOC);/*Utiliza fetch() para recuperar la primera fila del resultado de la consulta como un arreglo asociativo que 
    representa el registro de la tabla correspondiente al ID proporcionado y retorna el resultado.*/
  }

  public function deleteById($id, $idColumn = 'id')
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$idColumn} = :id");/*Se prepara la consulta sql para eliminar las filas de la tabla
    representada por $this->table donde el id coincide con el valor proporcionado*/
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL.*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute().Esto elimina las filas de la tabla que cumplen con la condición 
    especificada (es decir, donde el ID coincide con el valor proporcionado).*/
  }

  public function updateById($id, $data, $idColumn = 'id')
  {
    $sql = "UPDATE {$this->table} SET ";
    foreach ($data as $key => $value) {
      $sql .= "{$key} = :{$key}, ";
    }
    $sql = rtrim($sql, ', ') . " WHERE {$idColumn} = :id";

    $stmt = $this->db->prepare($sql);

    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }


  public function insert($data)
  {
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
}
