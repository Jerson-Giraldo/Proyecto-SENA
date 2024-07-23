<?php
class DynamicModel extends Orm
{
    public function __construct(PDO $connection, $tableName, $idColumn = 'id')
    {
        parent::__construct($tableName, $idColumn, $connection);
    }

    public function getTableStructure()
    {
        $query = "DESCRIBE " . $this->table; // Usa $this->table en lugar de $this->tableName
        $stmt = $this->db->prepare($query); // Usa $this->db para la conexión
        $stmt->execute();
        $structure = $stmt->fetchAll(PDO::FETCH_ASSOC); // Usa PDO::FETCH_ASSOC para obtener un array asociativo
        return $structure;
    }
}
