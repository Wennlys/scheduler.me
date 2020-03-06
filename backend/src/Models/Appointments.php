<?php


namespace Source\Models;


use Source\Core\Model;

class Appointments extends Model
{
    public function __construct()
    {
        parent::__construct("appointments", ["date"], true);
    }
}
