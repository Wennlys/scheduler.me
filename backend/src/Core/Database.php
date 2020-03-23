<?php declare(strict_types=1);

namespace Source\Core;

use Exception;
use PDOException;
use stdClass;
use DateTime;

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

    /** @var int|null */
    protected ?int $limit = null;

    /** @var int|null */
    protected ?int $offset = null;

    /** @var object|null */
    protected ?object $data = null;

    /**
     * Constructor.
     *
     * @param string $entity
     * @param array  $required
     * @param string $primary
     * @param bool   $timestamps
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
    public function find(?string $terms = null, ?string $params = null, string $columns = "*")
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
        try {
            $stmt = $this->connection->getConnection()->prepare(
                $this->statement . $this->group . $this->order . $this->limit . $this->offset
            );
            $stmt->execute($this->params);

            if (!$stmt->rowCount())
                return null;

            if ($all)
                return $stmt->fetchAll();

            return $stmt->fetchObject();
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    /**
     * CRUD Treatment
     */

    /**
     * @param array $data
     *
     * @return bool
     * @throws Exception
     */
    public function create(array $data): bool
    {
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
            $data["updated_at"] = $data["created_at"];
        }

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = $this->connection->getConnection()->prepare(
                "INSERT INTO " . $this->entity . " (" . $columns . ") VALUES (" . $values . ")"
            );

            return $stmt->execute($this->filter($data));
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
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
        if ($this->timestamps) {
            $data["updated_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
        }

        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = $this->connection->getConnection()->prepare(
                "UPDATE " . $this->entity . " SET " . $dateSet . " WHERE " . $terms
            );
            return $stmt->execute($this->filter(array_merge($data, $params)));
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    /**
     * @param string $terms
     * @param string|null $params
     * @return bool
     */
    public function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = $this->connection->getConnection()->prepare(
                "DELETE FROM " . $this->entity . " WHERE " . $terms
            );

            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
