<?php


namespace Source\Models;


use Source\Core\model;

class Appointments extends model
{
    public function __construct()
    {
        parent::__construct("appointments", ["date"], true);
    }
}
