<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Source\Core\Connection;
use Source\Models\UserDAO;


class UserShowController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserShowController constructor.
     *
     * @param Connection        $connection
     * @param ResponseInterface $response
     */
    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);

        $login = json_decode((string)$request->getBody())->login;
        $user = $userDao->findByLogin($login);

        $this->response->getBody()->write(json_encode($user));
        return $this->response->withStatus(200);
    }
}
