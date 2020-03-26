<?php declare(strict_types=1);

namespace Source\Core;

use Exception;
use PDOException;
use stdClass;
use DateTime;

/**
 * Class Database
 *
 * @package Source\Core
 */
class Database
{
    /** @var string $entity */
    protected string $entity;

    /** @var string $primary */
    protected string $primary;

    /** @var array|null $required */
    protected ?array $required;

    /** @var bool $timestamps */
    protected bool $timestamps;

    /** @var string|null */
    protected ?string $statement = null;

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

    /** @var object|null */
    protected ?object $data = null;

    /** @var Connection */
    private Connection $connection;

    /**
     * Constructor.
     *
     * @param Connection $connection
     * @param string     $entity
     * @param array      $required
     * @param string     $primary
     * @param bool       $timestamps
     */
    public function __construct(
        Connection $connection,
        string $entity,
        array $required,
        string $primary = 'id',
        bool $timestamps = true
    ) {
        $this->connection = $connection;
        $this->entity = $entity;
        $this->primary = $primary;
        $this->required = $required;
        $this->timestamps = $timestamps;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     *
     * @return string|null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return object|null
     */
    public function data()
    : ?object
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function safe()
    : ?array
    {
        $safe = (array)$this->data;
        unset($safe[$this->primary]);

        return $safe;
    }

    /**
     * @param string|null $terms
     * @param string|null $params
     * @param string      $columns
     *
     * @return Database
     */
    public function find(?string $terms = null, string $params = "", string $columns = "*")
    : Database {
        if ($terms) {
            $this->statement = "SELECT " . $columns . " FROM " . $this->entity . " WHERE " . $terms;
            parse_str($params, $this->params);
            return $this;
        }

        $this->statement = "SELECT " . $columns . " FROM " . $this->entity;
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
     * @return bool
     */
    protected function required()
    : bool
    {
        $data = (array)$this->data();
        foreach ($this->required as $field) {
            if (is_null($data[$field])) {
                return false;
            }
        }
        return true;
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
        $stmt = $this->connection->getConnection()->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * @param bool $all
     *
     * @return array|mixed|null
     */
    public function fetch(bool $all = false)
    {
        $stmt = $this->connection->getConnection()->prepare(
            $this->statement . $this->group . $this->order . $this->limit . $this->offset
        );
        $stmt->execute($this->params);

        if (!$stmt->rowCount())
            return null;

        if ($all)
            return $stmt->fetchAll();

        return $stmt->fetchObject();
    }

    /**
     * CRUD Treatment
     */

    /**
     * @param array $data
     *
     * @return string
     * @throws Exception
     */
    public function create(array $data): string
    {
        $connection = $this->connection->getConnection();
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
            $data["updated_at"] = $data["created_at"];
        }

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $stmt = $connection->prepare(
            "INSERT INTO " . $this->entity . " (" . $columns . ") VALUES (" . $values . ")"
        );

        $stmt->execute($this->filter($data));

        return $connection->lastInsertId();
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
        $connection = $this->connection->getConnection();
        if ($this->timestamps) {
            $data["updated_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
        }
        $dataSet = [];
        foreach ($data as $bind => $value) {
            $dataSet[] = "{$bind} = :{$bind}";
        }
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
    public function delete(string $terms, ?string $params): bool
    {
        $connection = $this->connection->getConnection();
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
