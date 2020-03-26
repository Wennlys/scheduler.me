<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;
use Source\Core\Connection;

use Exception;

/**
 * Class FileDAO
 *
 * @package Source\Models
 */
class FileDAO
{
    /** @var Database */
    private Database $database;

    /**
     * FileDAO constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection, "files", ["name", "path"]);
    }

    /**
     * @param File $file
     *
     * @return string
     * @throws Exception
     */
    public function save(File $file): string
    {
        return $this->database->create([
            "name" => $file->getName(),
            "path" => $file->getPath()
        ]);
    }
}
