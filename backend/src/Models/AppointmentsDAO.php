<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;

class AppointmentsDAO extends Database
{
    public function __construct()
    {
        parent::__construct("appointments", ["date"], true);
    }
}
