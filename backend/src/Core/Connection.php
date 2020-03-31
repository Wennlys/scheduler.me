<?php declare(strict_types=1);


namespace Source\Core;

use PDO;
use Exception;
use PDOException;

/**
 * SQL Database Connection Class
 *
 * @package Source\Core
 */
class Connection
{
    /** @const array */
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    /** @var PDO $conn */
    private ?PDO $conn = null;

    /** @var Connection|null $instance */
    private static ?Connection $instance = null;

    /** @var Exception|PDOException */
    public static $error;

    /**
     * Connection constructor.
     */
    final private function __construct()
    {
            $this->conn = new PDO(
                "mysql:host=" . SQL_DB_HOST . ";dbname=" . SQL_DB_NAME,
                SQL_DB_USER,
                SQL_DB_PASS,
                self::OPTIONS
            );
    }

    /**
     * @return Connection|null
     */
    public static function getInstance(): ?Connection
    {
        if (!self::$instance)
            self::$instance = new Connection;
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
