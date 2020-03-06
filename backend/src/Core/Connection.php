<?php


namespace Source\Core;

use PDOException;
use Exception;
use PDO;

/**
 * Class Connection
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

    /**
     * @var PDO
     */
    private static PDO $instance;
    /**
     * @var Exception|PDOException
     */
    public static $error;

    /**
     * @return PDO|null
     */
    public static function getInstance(): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . SQL_DB_HOST . ";dbname=" . SQL_DB_NAME,
                    SQL_DB_USER,
                    SQL_DB_PASS,
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                self::$error = $exception;
            }
        }
        return self::$instance;
    }
}
