<?php 
declare(strict_types=1);

namespace Source\Core;

use MongoDB\Client;
use MongoDB\Database;

class MongoConnection
{
    private ?Database $conn = null;
    private static ?MongoConnection $instance = null;

    final private function __construct()
    {
        $this->conn = (new Client('mongodb://172.17.0.2:27017/'))->selectDatabase(NOSQL_DB_NAME);
    }

    public static function getInstance(): ?MongoConnection
    {
        if (!self::$instance)
            self::$instance = new MongoConnection;
        return self::$instance;
    }

    public function getConnection(): Database
    {
        return $this->conn;
    }
}
