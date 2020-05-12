<?php declare(strict_types=1);


namespace Source\Core;

use MongoDB\Client;
use MongoDB\Database;

/**
 * NoSQL Database Connection Class
 *
 * @package Source\Core
 */
class MongoConnection
{
    /** @var Database|null */
    private ?Database $conn = null;

    /** @var MongoConnection|null $instance */
    private static ?MongoConnection $instance = null;

    /**
     * MongoConnection constructor.
     */
    final private function __construct()
    {
        $this->conn = (new Client('mongodb://172.17.0.2:27017/'))->selectDatabase(NOSQL_DB_NAME);
    }

    /**
     * @return Connection|null
     */
    public static function getInstance(): ?MongoConnection
    {
        if (!self::$instance)
            self::$instance = new MongoConnection;
        return self::$instance;
    }

    /**
     * @return Database
     */
    public function getConnection(): Database
    {
        return $this->conn;
    }
}
