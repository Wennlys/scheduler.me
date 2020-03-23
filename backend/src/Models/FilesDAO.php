<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;

class FilesDAO extends Database
{
    public function __construct()
    {
        parent::__construct("files", ["name", "path"], true);
    }
}
