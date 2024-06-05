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
    return $stmt->fetchAll();/*fetchAll() para recuperar todas las filas resultantes de la ejecución de la consulta y se devuelve como un array.
    Este array contendrá todos los registros seleccionados de la tabla.*/
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE idproducto = :id");/*Prepara una consulta sql para seleccionar 
    todos los campos de la tabla donde el id coincida con el valor proporcionado*/
    $stmt->bindValue(":id", $id);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute(). Esto ejecuta la consulta con el valor del ID proporcionado.*/
    return $stmt->fetch();/*Utiliza fetch() para recuperar la primera fila del resultado de la consulta como un arreglo asociativo que 
    representa el registro de la tabla correspondiente al ID proporcionado y retorna el resultado.*/
  }

  public function deleteById($id)
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE idproducto = :id");/*Se prepara la consulta sql para eliminar las filas de la tabla
    representada por $this->table donde el id coincide con el valor proporcionado*/
    $stmt->bindValue(":id", $id);/*Vincula el valor del ID proporcionado al marcador de posición :id utilizando bindValue(":id", $id). 
    Esto asegura que el valor del ID se trate correctamente y evita la inyección SQL.*/
    $stmt->execute();/*Ejecuta la consulta preparada utilizando execute().Esto elimina las filas de la tabla que cumplen con la condición 
    especificada (es decir, donde el ID coincide con el valor proporcionado).*/
  }

  public function updateById($id, $data)
  {
    $sql = "UPDATE {$this->table} SET ";
    foreach ($data as $key => $value) {
      $sql .= "{$key} = :{$key}, ";
    }
    $sql = rtrim($sql, ', ');
    $sql .= " WHERE idproducto = :id";

    $stmt = $this->db->prepare($sql);

    foreach ($data as $key => $value) {
      $stmt->bindValue(":{$key}", $value);
    }
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }


  public function insert($data)/*El parametro data es un array asociativo donde la clave es el nombre de la columna y el valor 
  son los datos que se quieren insertar en esas columnas de la tabla */
  {
    $sql = "INSERT INTO {$this->table} (";
    foreach ($data as $key => $value) {/*En cada iteración de este ciclo se agrega el nombre de una columna {$key}, seguido de una coma*/
      $sql .= "{$key},"; //La variable sql tiene un punto que es para concatenar la clave con una coma a la consulta.
    }
    $sql = trim($sql, ',');/*trim($sql, ','): Después del ciclo, se utiliza trim para eliminar la coma final que queda al final 
    de la lista de columnas.*/
    $sql .= ") VALUES(";/*aqui la variable sql está concatenando values junto con el contenido actual de la variable sql.
    ") VALUES(";: Estas son cadenas de texto. La primera es parte de la consulta SQL y representa el final de la lista de columnas 
    en la declaración INSERT INTO. La segunda cadena representa el inicio de los valores que se insertarán en esas columnas.*/
    foreach ($data as $key => $value) {/*Similar al primer ciclo, se agrega un placeholder para cada valor seguido de una coma.
       Nota: un placeholder es un marcador de posición, en este caso seria ":{$key},"*/
      $sql .= ":{$key},"; //La variable sql tiene un punto que es para concatenar el placeholder con una coma a la consulta.
    }
    $sql = trim($sql, ',');/*De nuevo, después del ciclo, se elimina la coma final que queda al final de la lista de placeholders.*/
    $sql .= ")"; //fin de la consulta.

    $stmt = $this->db->prepare($sql);/*Aqui se prepara la consulta sql para su ejecución.
    La consulta preparada se crea utilizando el método prepare() 
    de la conexión de base de datos $this->db y se pasa como parámetro el SQL almacenado en la variable $sql. */
    foreach ($data as $key => $value) {/*Este ciclo recorre cada elemento del array $data. En cada iteración del ciclo $key tendra el valor
      de la columna de la tabla y $value contendrá el valor que se quiere insertar en esa columna.*/
      $stmt->bindValue(":{$key}", $value);/*Dentro del bucle foreach, se utiliza el método bindValue() para vincular cada valor de $value 
      a su respectivo marcador de posición en la consulta preparada. Los marcadores de posición en la consulta están representados por 
      :{$key}, donde $key es el nombre de la columna.*/
    }
    $stmt->execute();/*Después de haber vinculado todos los valores a la consulta preparada, se ejecuta la consulta utilizando el método 
    execute(). Esto envía la consulta SQL al servidor de la base de datos para su ejecución, con los valores vinculados sustituyendo 
    los marcadores de posición en la consulta.*/
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
