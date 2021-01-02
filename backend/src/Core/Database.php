<?php 
declare(strict_types=1);

namespace Source\Core;

use DateTime;
use Exception;
use PDO;

class Database
{
    private PDO $connection;
    protected string $entity;
    protected bool $timestamps;
    protected ?string $statement = null;
    private ?string $join = null;
    protected ?string $and = null;
    protected ?array $params = null;
    protected ?string $group = null;
    protected ?string $order = null;
    protected ?string $limit = null;
    protected ?string $offset = null;

    public function __construct(Connection $connection, string $entity, bool $timestamps = true)
    {
        $this->connection = $connection->getConnection();
        $this->entity = $entity;
        $this->timestamps = $timestamps;
    }

    protected function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }

    public function count(): int
    {
        $stmt = $this->connection->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    public function find(?string $columns = "*", ?string $terms = null, string $params = ""): Database {
        $columns = $columns ?? "*";

        if ($terms) {
            $this->statement = "SELECT " . $columns . " FROM " . $this->entity . " WHERE " .
                $terms;
            parse_str($params, $this->params);
            return $this;
        }

        $this->statement = "SELECT " . $columns . " FROM " . $this->entity;
        parse_str($params, $this->params);
        return $this;
    }

    public function join(string $clause, string $table): ?Database
    {
        $this->join = " INNER JOIN {$table} ON ({$clause})";
        return $this;
    }

    public function and(string $clause): ?Database
    {
        $this->and .= " AND {$clause}";
        return $this;
    }

    public function group(string $column): ?Database {
        $this->group = " GROUP BY {$column}";
        return $this;
    }

    public function order(string $columnOrder): ?Database {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    public function limit(int $limit): ?Database {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset): ?Database {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    public function fetch(bool $all = false)
    {
        $stmt = $this->connection->prepare(
            $this->statement . $this->join . $this->and . $this->group . $this->order .
            $this->limit . $this->offset
        );
        $stmt->execute($this->params);

        if (!$stmt->rowCount()) return null;

        if ($all) return $stmt->fetchAll();

        return $stmt->fetchObject();
    }

    public function create(array $data): string
    {
        $connection = $this->connection;
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
            $data["updated_at"] = $data["created_at"];
        }

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $stmt = $connection->prepare(
            "INSERT INTO {$this->entity} ({$columns}) VALUES ({$values})"
        );

        $stmt->execute($this->filter($data));
        return $this->connection->lastInsertId();
    }

    public function update(array $data, string $terms, string $params): bool
    {
        $connection = $this->connection;
        if ($this->timestamps) {
            $data["updated_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
        }
        $dataSet = [];
        foreach ($data as $bind => $value) $dataSet[] = "{$bind} = :{$bind}";

        $dataSet = implode(", ", $dataSet);
        parse_str($params, $params);

        $stmt = $connection->prepare(
            "UPDATE " . $this->entity . " SET " . $dataSet . " WHERE " . $terms
        );
        return $stmt->execute($this->filter(array_merge($data, $params)));
    }

    public function delete(string $terms, string $params = ""): bool
    {
        $connection = $this->connection;
        $stmt = $connection->prepare(
            "DELETE FROM " . $this->entity . " WHERE " . $terms
        );

        if ($params) {
            parse_str($params, $params);
            $stmt->execute($params);
            return true;
        }
        return $stmt->execute();
    }
}
