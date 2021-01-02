<?php 
declare(strict_types=1);

namespace Source\Models;

use Source\Core\Database;
use Source\Core\Connection;
use Exception;

class FileDAO
{
    private Database $database;

    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection, "files");
    }

    public function save(File $file): string
    {
        return $this->database->create([
            "name" => $file->getName(),
            "path" => $file->getPath()
        ]);
    }
}
