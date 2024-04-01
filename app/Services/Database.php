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
    $this->connection = new PDO('mysql:host=localhost;dbname=taller_sql', 'root', '', $options);
    $this->connection->exec('SET CHARACTER SET UTF8');
  }

  public function getconnection()
  {
    return $this->connection;
  }

  public function closeConnection()
  {
    $this->connection = null;
  }
}
