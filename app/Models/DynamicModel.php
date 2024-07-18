<?php
class DynamicModel extends Orm
{
    public function __construct(PDO $coneccion, $tableName, $idColumn = 'id')
    {
        parent::__construct($tableName, $idColumn, $coneccion);
    }
}