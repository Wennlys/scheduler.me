<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;

class UserIndexController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function index(): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);

        $this->response->getBody()->write(json_encode($userDao->findAll()));
        return $this->response->withStatus(200);
    }
}
