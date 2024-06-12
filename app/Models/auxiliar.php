<?php
class Auxiliar extends Orm
{
  public function __construct(PDO $coneccion)
  {
    parent::__construct('id', 'auxiliar', $coneccion);
  }
}
