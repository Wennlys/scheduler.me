<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * Class User
 *
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["user_name", "first_name", "last_name", "email", "password_hash"]);
    }
}
