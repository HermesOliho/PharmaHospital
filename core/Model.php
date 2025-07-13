<?php

namespace HeromTech;

use Conf;
use PDO;
use stdClass;

class Model
{
    public string $db_conf = "default";
    public ?string $table = null;
    public string $primary_key = "id";

    protected ?PDO $pdo  = null;
    protected static array $connections = [];

    public function __construct()
    {
        // Initialisation de quelques variables
        if (is_null($this->table)) {
            $this->table = strtolower(get_class($this)) . 's';
            $this->table = str_ireplace("models\\", "", $this->table);
        }
        // Vérifier s'il existe déjà une connexion à la BDD
        if (isset(Model::$connections[$this->db_conf])) {
            $this->pdo = Model::$connections[$this->db_conf];
        } else {
            // Tentative de connexion à la BDD
            try {
                $conf = Conf::$databases[$this->db_conf];
                $this->pdo = new PDO(
                    "mysql:host={$_ENV['DB_HOST']}:{$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8;",
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD']
                );
            } catch (\PDOException $e) {
                if (Conf::$debug >= 1) {
                    die($e->getMessage());
                } else {
                    die("Impossible de se connecter à la base des donnés");
                }
            }
            // Sauvegarde de la connexion
            Model::$connections[$this->db_conf] = $this->pdo;
        }
    }

    /**
     * Find records in the table
     * 
     * @return array
     */
    public function find(array $req = []): array
    {
        $sql = "SELECT ";
        // Récupérer les champs
        if (isset($req['fields'])) {
            if (is_array($req['fields'])) {
                $fields = implode(", ", $req['fields']);
                $sql .= "{$fields} FROM {$this->table}";
            } else {
                $sql .= "{$req['fields']} FROM {$this->table}";
            }
        } else {
            $sql .= "* FROM {$this->table}";
        }
        // Former la condition
        if (isset($req['conditions'])) {
            if (!is_array($req['conditions'])) {
                $sql .= " WHERE " . $req['conditions'];
            } else {
                $cond = [];
                foreach ($req['conditions'] as $k => $v) {
                    if (!is_numeric($v)) {
                        $v = "'" . addslashes($v) . "'";
                    }
                    $cond[] = $k . ' = ' . $v;
                }
                $sql .= " WHERE " . implode(" AND ", $cond);
            }
        }
        // Récupérer la limite
        if (isset($req['limit'])) {
            $sql .= " LIMIT {$req['limit']}";
        }
        // Exécuter la requête
        $pre = $this->pdo->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Find a record in the table
     * @return stdClass|false|null
     */
    public function findFirst(array $req = []): stdClass|false|null
    {
        return current($this->find($req));
    }

    public function findCount(?string $condition = null)
    {
        $query = ['fields' => "COUNT({$this->primary_key}) AS count"];
        if (is_string($condition) and !empty($condition)) {
            $query['conditions'] = $condition;
        }
        return $this->findFirst($query);
    }

    public function create(array $fields): int
    {
        $sql = "INSERT INTO {$this->table}";
        $columns = array_keys($fields);
        $sql .= "(" . implode(',', $columns) . ")";
        $prepared_columns = [];
        foreach ($fields as $field) {
            array_push($prepared_columns, '?');
        }
        $sql .= " VALUES(" . implode(", ", $prepared_columns) . ")";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($fields));
        $affected_rows = $statement->rowCount();
        $statement->closeCursor();
        return $affected_rows;
    }

    public function update(array $fields, string $condition): int
    {
        if (empty($condition)) {
            return 0;
        }
        $sql = "UPDATE {$this->table} SET ";
        $prepared_columns = [];
        foreach (array_keys($fields) as $col) {
            array_push($prepared_columns, $col . " = ?");
        }
        $sql .= implode(", ", $prepared_columns) . " WHERE " . $condition;
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($fields));
        $affected_rows = $statement->rowCount();
        $statement->closeCursor();
        return $affected_rows;
    }

    public function delete(string $condition): int
    {
        if (empty($condition)) {
            return 0;
        }
        $sql = "DELETE FROM {$this->table} WHERE " . $condition;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $affected_rows = $statement->rowCount();
        $statement->closeCursor();
        return $affected_rows;
    }
}
