<?php


namespace Source\Models;


use Source\Core\Model;

class Files extends Model
{
    public function __construct()
    {
        parent::__construct("files", ["name", "path"], true);
    }
}
