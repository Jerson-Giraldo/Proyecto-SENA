<?php
/**Este ORM nos va a permitir hacer consultas y transacciones en la base de datos.
 en este ORM debo crear una clase por cada tabla que tenga en la base de datos, estas clases van a heredar de la clase ORM
 todos los métodos que esten en la clase ORM
*/
class Orm
{
  protected $id;// Esta propiedad sirve para almacenar el identificador de la tabla
  protected $table;// Esta propiedad va hacer para almacenar el nombre de la tabla
  protected $db;// Esta propiedad va hacer para almacenar la conección de la base de datos para realizar consultas y transacciones

  public function __construct($id, $table, PDO $coneccion)
  {
    $this->id = $id;
    $this->table = $table;
    $this->db = $coneccion;
  }

  public function getAll($id) //Para traer todos los registros de una tabla filtrados por un id.
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id= ?");/*Prepara una consulta SQL utilizando prepare(), 
    donde selecciona todos los campos (*) de la tabla representada por $this->table donde el ID coincide con el valor proporcionado.*/
    $stmt->execute([$id]);/*Ejecuta la consulta utilizando execute([$id]), pasando el ID como un arreglo de parámetros. 
    Esto ejecuta la consulta preparada con el ID proporcionado, lo que evitará la inyección SQL.*/
    return $stmt->fetchAll();//fetchAll() para recuperar todas las filas que coinciden con el ID de la consulta y las devuelve como un arreglo de filas.
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");/*Prepara una consulta sql para seleccionar 
    todos los campos de la tabla donde el id coincida con el valor proporcionado*/
    $stmt->bindValue(":id", $id);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute(). Esto ejecuta la consulta con el valor del ID proporcionado.*/
    return $stmt->fetch();/*Utiliza fetch() para recuperar la primera fila del resultado de la consulta como un arreglo asociativo que 
    representa el registro de la tabla correspondiente al ID proporcionado y retorna el resultado.*/
  }

  public function deleteById($id)
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");/*Se prepara la consulta sql para eliminar las filas de la tabla
    representada por $this->table donde el id coincide con el valor proporcionado*/
    $stmt->bindValue("id", $id);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL.*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute().Esto elimina las filas de la tabla que cumplen con la condición 
    especificada (es decir, donde el ID coincide con el valor proporcionado).*/
  }

  public function updateById($id, $data) //El párametro data nos sirve para pasar toda la información que queremos actualizar
  {
    $sql = "UPDATE {$this->table} SET";/*Se construye la consulta sql de actualización en la variable sql para actualizar la tabla
    con el nombre especificado ($this->table).*/
    foreach ($data as $key => $value) {/*Se itera sobre el par clave-valor en el arreglo $data */
      $sql .= "{$key} = :{$key},";/*Cada clave en el arreglo $data representa un nombre de columna, 
      y su valor correspondiente representa el nuevo valor para esa columna en la base de datos. */
    }

    $sql = rtrim($sql, ',');// Elimina la coma adicional al final de la lista de columnas y valores
    $sql .= " WHERE id = :id";// Se agrega la cláusula WHERE para actualizar la fila con el id especificado.
    $stmt = $this->db->prepare($sql);//Prepara la consulta SQL utilizando el objeto de conexión a la base de datos ($this->db).
    
    foreach ($data as $key => $value) /*Itera sobre el arreglo $data nuevamente para vincular los valores a los marcadores de posición 
    en la consulta preparada.*/
    {
      $stmt->bindValue(":{$key}", $value);// Vincula cada valor al marcador de posición correspondiente.
    }
    $stmt->bindValue(":id", $id);//Vincula el valor del identificador (id) al marcador de posición correspondiente.
    $stmt->execute();//Ejecuta la consulta SQL.
  }

  public function insert($data)/*El parametro data es un array asociativo donde la clave es el nombre de la columna y el valor 
  son los datos que se quieren insertar en esas columnas de la tabla */
  {
    $sql = "INSERT INTO {$this->table} (";
    foreach ($data as $key => $value) {/*En cada iteración de este ciclo se agrega el nombre de una columna {$key}, seguido de una coma*/
      $sql .= "{$key},";//La variable sql tiene un punto que es para concatenar la clave con una coma a la consulta.
    }
    $sql = trim($sql, ',');/*trim($sql, ','): Después del ciclo, se utiliza trim para eliminar la coma final que queda al final 
    de la lista de columnas.*/
    $sql .= ") VALUES(";/*aqui la variable sql está concatenando values junto con el contenido actual de la variable sql.
    ") VALUES(";: Estas son cadenas de texto. La primera es parte de la consulta SQL y representa el final de la lista de columnas 
    en la declaración INSERT INTO. La segunda cadena representa el inicio de los valores que se insertarán en esas columnas.*/
    foreach ($data as $key => $value) {/*Similar al primer ciclo, se agrega un placeholder para cada valor seguido de una coma.
       Nota: un placeholder es un marcador de posición, en este caso seria ":{$key},"*/
      $sql .= ":{$key},";//La variable sql tiene un punto que es para concatenar el placeholder con una coma a la consulta.
    }
    $sql = trim($sql, ',');/*De nuevo, después del ciclo, se elimina la coma final que queda al final de la lista de placeholders.*/
    $sql .= ")";//fin de la consulta.

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
