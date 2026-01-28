<?php
require_once __DIR__ . '/PDOModel.php';

class BaseModel extends PDOModel
{
    public string $class;
    protected string $tableName = '';

    protected array $exclude = [
        'exclude','db','class','host','dbname','user','pass','pdo','tableName',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->class = (new \ReflectionClass($this))->getShortName();
        $this->tableName = str_replace('Model', '', $this->class);
    }

    private function getModelData(): array
    {
        $data = [];

        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();

            if (in_array($name, $this->exclude)) {
                continue;
            }

            $getter = 'get' . ucfirst($name);

            if (method_exists($this, $getter)) {
                $value = $this->$getter();
                if (!is_object($value)) {
                    $data[$name] = $value;
                }
            } elseif ($property->isPublic()) {
                $value = $this->$name;
                if (!is_object($value)) {
                    $data[$name] = $value;
                }
            }
        }

        return $data;
    }

    public function insertIntoDatabase()
    {
        $data = $this->getModelData();

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));

        $sql = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);

            $reflection = new ReflectionClass($this);
            $properties = $reflection->getProperties();

            $primaryKey = null;
            foreach ($properties as $property) {
                $name = $property->getName();
                if (str_starts_with($name, 'id_') || str_ends_with($name, '_id')) {
                    $primaryKey = $name;
                    break;
                }
            }

            if ($primaryKey) {
                $this->$primaryKey = (int)$this->pdo->lastInsertId();
            }
        } catch (PDOException $e) {
            echo 'Erreur INSERT : ' . $e->getMessage();
        }
    }

    public function updateDatabase($IdPrimaryKey = 'id')
    {
        $data = $this->getModelData();

        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $primaryKey = null;
        $primaryKeyValue = null;

        foreach ($properties as $property) {
            $name = $property->getName();
            if (str_starts_with($name, 'id_') || str_ends_with($name, '_id')) {
                $primaryKey = $name;
                if ($property->isPublic()) {
                    $primaryKeyValue = $this->$name;
                } else {
                    $getter = 'get' . ucfirst($name);
                    if (method_exists($this, $getter)) {
                        $primaryKeyValue = $this->$getter();
                    }
                }
                break;
            }
        }

        if (!$primaryKey || empty($primaryKeyValue)) {
            $primaryKey = $IdPrimaryKey;
            $primaryKeyValue = $this->$primaryKey ?? null;
        }

        if (!$primaryKey || empty($primaryKeyValue)) {
            throw new Exception('Cle primaire introuvable pour la mise a jour.');
        }

        $setParts = [];
        $params = [];

        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
            $params[$column] = $value;
        }

        $sql = "UPDATE {$this->tableName} SET " . implode(', ', $setParts)
            . " WHERE {$primaryKey} = :pk";

        try {
            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $k => $v) {
                $stmt->bindValue(":$k", $v);
            }

            $stmt->bindValue(':pk', $primaryKeyValue, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur UPDATE : ' . $e->getMessage();
        }
    }

    public function deleteFromDatabase($id, $idName = 'id')
    {
        $this->getModelData();

        $sql = "DELETE FROM {$this->tableName} WHERE {$idName} = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur DELETE : ' . $e->getMessage();
        }
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id, string $idName)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE  {$idName} = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByField(string $field, mixed $value)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :value";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __toString(): string
    {
        $data = $this->getModelData();
        $result = [];

        foreach ($data as $key => $value) {
            $type = gettype($value);
            $result[] = "[{$type}] {$key} = {$value}";
        }

        return "PDOModel::{$this->tableName} { " . implode(', ', $result) . ' }';
    }

    public function addExclude(string $field): void
    {
        if (!in_array($field, $this->exclude)) {
            $this->exclude[] = $field;
        }
    }
}
