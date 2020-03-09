<?php


namespace Source\Core;


use Source\Models\User;
use Laminas\Diactoros\Response;
use PDO;

/**
 * Class Controller
 *
 * @package Source\Core
 */
abstract class Controller
{
    /** @var User $user */
    protected User $user;

    /** @var Response $response */
    protected Response $response;

    /** @var array $content */
    protected array $content = [];

    /** @var PDO|null */
    protected ?PDO $instance;

    public function __construct()
    {
        $this->user = new User();
        $this->response = new Response();
        $this->instance = Connection::getInstance();
    }

    public function getRows(?string $terms = null, string $columns = '*') {

        if ($terms)
        return (($this->instance)->query(
           "SELECT" . $columns . "FROM scheduler.users" . " WHERE " . $terms))
           ->fetchAll();

        return (($this->instance)->query("SELECT" . $columns . "FROM scheduler.users"))->fetchAll();
    }
}
