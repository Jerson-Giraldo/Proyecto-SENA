<?php
class Usuario extends Orm
{
  public function __construct(PDO $coneccion)
  {
    parent::__construct('id', 'usuario', $coneccion);
  }
}
