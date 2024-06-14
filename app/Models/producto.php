<?php
class Producto extends Orm
{
    public function __construct(PDO $coneccion)
    {
        parent::__construct('id', 'producto', $coneccion);
    }

    public function getTableColumns()
    {
        $stmt = $this->db->query("DESCRIBE {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}