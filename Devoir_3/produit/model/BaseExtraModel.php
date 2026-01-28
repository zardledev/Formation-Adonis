<?php
require_once __DIR__ . '/BaseModel.php';

class BaseExtraModel extends BaseModel
{
    public function __construct(string $tableName)
    {
        parent::__construct();
        $this->tableName = $tableName;
    }

    public function getAllRequest(array $joins = [])
    {
        $sql = "SELECT * FROM {$this->tableName}";

        foreach ($joins as $join) {
            if (!isset($join['table'], $join['foreign'], $join['reference'])) {
                throw new InvalidArgumentException('Chaque join doit contenir : table, foreign, reference');
            }

            $sql .= "
                INNER JOIN {$join['table']}
                ON {$this->tableName}.{$join['foreign']} = {$join['table']}.{$join['reference']}
            ";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllRequestById(array $joins = [], $idName, $id)
    {
        $sql = "SELECT * FROM {$this->tableName}";

        foreach ($joins as $join) {
            if (!isset($join['table'], $join['foreign'], $join['reference'])) {
                throw new InvalidArgumentException('Chaque join doit contenir : table, foreign, reference');
            }

            $sql .= "
                INNER JOIN {$join['table']}
                ON {$this->tableName}.{$join['foreign']} = {$join['table']}.{$join['reference']}
            ";
        }

        $sql .= " WHERE {$this->tableName}.{$idName} = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->tableName}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total'];
    }

    public function getCountById($id, string $idName = 'id')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->tableName} WHERE {$idName} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total'];
    }
}
