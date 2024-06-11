<?php
class Factura extends Orm
{
  public function __construct(PDO $coneccion)
  {
    parent::__construct('id', 'factura', $coneccion);
  }
}
