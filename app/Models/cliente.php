<?php
class Cliente extends Orm
{
  public function __construct(PDO $coneccion)
  {
    parent::__construct('id', 'cliente', $coneccion); //pasamos los valores de los párametros de la clase padre ORM
  }
}
