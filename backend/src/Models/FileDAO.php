<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;
use Source\Core\Connection;

class FileDAO
{
    /** @var Database */
    private Database $database;

    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection, "files", ["name", "path"]);
    }

    public function save(File $file): bool
    {
        return $this->database->create(
            [
                "name" => $file->getName(),
                "path" => $file->getPath()
            ]
        );
    }
}
