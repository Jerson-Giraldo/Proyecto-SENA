<?php
class DataBase
{
  private $connection;
  public function __construct()
  {
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    /**En la linea 12 de PDO se colocó $options para que cada vez que se haga una fetch nos devuelva un array asociativo */
    $this->connection = new PDO('mysql:host=localhost;dbname=software-ciclo', 'root', '', $options);
    $this->connection->exec('SET CHARACTER SET UTF8'); //indicamos el juego de caracteres que vamos a usar
  }
  /** En el método getConnection retornamos la concección que se creó con new PDO, 
   * es de esta manera que la clase DataBase va a traer la conección*/
  public function getConnection()
  {
    return $this->connection;
  }

  public function closeConnection()
  {
    $this->connection = null;
  }
}


/*En la carpeta Services vamos almacenar todos los archivos que nos van a servir para realizar peticiones a servicios externos de nuestra app */