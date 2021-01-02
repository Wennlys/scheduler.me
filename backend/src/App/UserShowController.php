<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;
use Source\Models\User;
use Exception;

class UserShowController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $login = json_decode((string)$request->getBody())->login;

        $user = new User();
        $userDao = new UserDAO($this->connection);

        if (is_email($login)) {
            $user->setEmail($login);
        } else {
            $user->setUserName($login);
        }

        $this->response->getBody()->write(json_encode($userDao->findByLogin($user)));
        return $this->response->withStatus(200);
    }
}
