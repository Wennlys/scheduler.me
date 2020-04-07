<?php declare(strict_types=1);

namespace Source\Core;

use DateTime;
use Exception;
use PDO;

/**
 * Class Database
 *
 * @package Source\Core
 */
class Database
{
    /** @var PDO */
    private PDO $connection;

    /** @var string $entity */
    protected string $entity;

    /** @var bool $timestamps */
    protected bool $timestamps;

    /** @var string|null */
    protected ?string $statement = null;

    /** @var string|null */
    private ?string $join = null;

    /** @var string|null */
    protected ?string $and = null;

    /** @var array|null */
    protected ?array $params = null;

    /** @var string|null */
    protected ?string $group = null;

    /** @var string|null */
    protected ?string $order = null;

    /** @var string|null */
    protected ?string $limit = null;

    /** @var string|null */
    protected ?string $offset = null;

    /**
     * Constructor.
     *
     * @param Connection $connection
     * @param string     $entity
     * @param bool       $timestamps
     */
    public function __construct(Connection $connection, string $entity, bool $timestamps = true)
    {
        $this->connection = $connection->getConnection();
        $this->entity = $entity;
        $this->timestamps = $timestamps;
    }

    /**
     * @param array $data
     *
     * @return array|null
     */
    protected function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }

    /**
     * @return int
     */
    public function count()
    : int
    {
        $stmt = $this->connection->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * @param string|null $terms
     * @param string|null $params
     * @param string|null $columns
     *
     * @return Database
     */
    public function find(?string $columns = "*", ?string $terms = null, string $params = "")
    : Database {
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

    /**
     * @param string $clause
     * @param string $table
     *
     * @return Database|null
     */
    public function join(string $clause, string $table)
    : ?Database
    {
        $this->join .= " INNER JOIN {$table} ON ({$clause})";
        return $this;
    }

    /**
     * @param string $clause
     *
     * @return Database|null
     */
    public function and(string $clause)
    : ?Database
    {
        $this->and .= " AND ({$clause})";
        return $this;
    }

    /**
     * @param string $column
     *
     * @return Database|null
     */
    public function group(string $column)
    : ?Database {
        $this->group = " GROUP BY {$column}";
        return $this;
    }

    /**
     * @param string $columnOrder
     *
     * @return Database|null
     */
    public function order(string $columnOrder)
    : ?Database {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    /**
     * @param int $limit
     *
     * @return Database|null
     */
    public function limit(int $limit)
    : ?Database {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param int $offset
     *
     * @return Database|null
     */
    public function offset(int $offset)
    : ?Database {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param bool $all
     *
     * @return array|mixed|null
     */
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

    /**
     * @param array $data
     *
     * @return bool
     * @throws Exception
     */
    public function create(array $data): bool
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

        return $stmt->execute($this->filter($data));
    }

    /**
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return bool
     * @throws Exception
     */
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

    /**
     * @param string $terms
     * @param string|null $params
     * @return bool
     */
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

    /**
     * @return array|mixed|null
     */
    public function findByLastId()
    {
        return $this->find('*', "id = {$this->connection->lastInsertId()}")->fetch();
    }
}
