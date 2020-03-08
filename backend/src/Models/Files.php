<?php


namespace Source\Models;


use Source\Core\model;

class Files extends model
{
    public function __construct()
    {
        parent::__construct("files", ["name", "path"], true);
    }
}
