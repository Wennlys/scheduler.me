<?php

namespace Source\Core;

use Exception;
use PDO;
use PDOException;
use stdClass;
use DateTime;

abstract class Model
{
    /** @var string|null $entity */
    private string $entity;

    /** @var string|null $primary */
    private string $primary;

    /** @var array|null $required */
    private array $required;

    /** @var string|null $timestamps */
    private $timestamps;

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

    /** @var PDOException|null */
    protected ?PDOException $fail = null;

    /** @var object|null */
    protected ?object $data = null;
    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Constructor.
     * @param string $entity
     * @param array $required
     * @param string $primary
     * @param bool $timestamps
     */
    public function __construct(string $entity, array $required, string $primary = 'id', bool $timestamps = true)
    {
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
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return object|null
     */
    public function data(): ?object
    {
        return $this->data;
    }

    /**
     * @return PDOException|Exception|null
     */
    public function fail()
    {
        return $this->fail;
    }

    /**
     * @param string|null $terms
     * @param string|null $params
     * @param string $columns
     *
     * @return model
     */
    public function find(?string $terms = null, ?string $params = null, string $columns = "*"): model
    {
        if ($terms) {
            $this->statement = "SELECT " . $columns . " FROM " . $this->entity . " WHERE " . $terms;
            parse_str($params, $this->params);
            return $this;
        }

        $this->statement = "SELECT " . $columns . " FROM " . $this->entity;
        return $this;
    }

    /**
     * @param int $id
     * @param string $columns
     *
     * @return model|null
     */
    public function findById(int $id, string $columns = "*")
    : ?model
    {
        $find = $this->find($this->primary . " = :id", "id={$id}", $columns);
        return $find->fetch();
    }

    /**
     * @param string $column
     * @return model|null
     */
    public function group(string $column)
    : ?model
    {
        $this->group = " GROUP BY {$column}";
        return $this;
    }

    /**
     * @param string $columnOrder
     * @return model|null
     */
    public function order(string $columnOrder)
    : ?model
    {
        $this->order = " ORDER BY {$columnOrder}";
        return $this;
    }

    /**
     * @param int $limit
     * @return model|null
     */
    public function limit(int $limit)
    : ?model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    /**
     * @param int $offset
     * @return model|null
     */
    public function offset(int $offset)
    : ?model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * @param bool $all
     * @return array|mixed|null
     */
    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connection::getInstance()->prepare($this->statement . $this->group . $this->order . $this->limit . $this->offset);
            $stmt->execute($this->params);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($all) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
            }

            return $stmt->fetchObject(static::class);
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $stmt = Connection::getInstance()->prepare($this->statement);
        $stmt->execute($this->params);
        return $stmt->rowCount();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $primary = $this->primary;
        $id = null;

        try {
            if (!$this->required()) {
                throw new Exception("Preencha os campos necessários");
            }

            /** Update */
            if (!empty($this->data->$primary)) {
                $this->id = $this->data->$primary;
                $this->update($this->safe(), $this->primary . " = :id", "id={$id}");
            }

            /** Create */
            if (empty($this->data->$primary)) {
                $this->id = $this->create($this->safe());
            }

            if (!$id) {
                return false;
            }

            $this->data = $this->findById($id)->data();
            return true;
        } catch (Exception|PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        $primary = $this->primary;
        $id = $this->data->$primary;

        if (empty($id)) {
            return false;
        }

        $destroy = $this->delete($this->primary . " = :id", "id={$id}");
        return $destroy;
    }

    /**
     * @return bool
     */
    protected function required(): bool
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
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        unset($safe[$this->primary]);

        return $safe;
    }

    /**
     * CRUD Treatment
     */

    /**
     * @param array $data
     *
     * @return int|null
     * @throws Exception
     */
    protected function create(array $data): ?int
    {
        if ($this->timestamps) {
            $data["created_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
            $data["updated_at"] = $data["created_at"];
        }

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connection::getInstance()->prepare("INSERT INTO {$this->entity} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));

            return Connection::getInstance()->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     * @throws Exception
     */
    protected function update(array $data, string $terms, string $params): ?int
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

            $stmt = Connection::getInstance()->prepare("UPDATE {$this->entity} SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
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
            $stmt = Connection::getInstance()->prepare("DELETE FROM {$this->entity} WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }
}
