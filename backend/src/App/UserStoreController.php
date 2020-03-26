<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Source\Core\Connection;
use Source\Models\UserDAO;
use Source\Models\User;
use Exception;


class UserStoreController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserStoreController constructor.
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
     * @throws Exception
     */
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $reqBody = json_decode((string)$request->getBody(), true);

        $user = new User();
        $userDao = new UserDAO($this->connection);

        $user->setUserName($reqBody['user_name']);
        $user->setFirstName($reqBody['first_name']);
        $user->setLastName($reqBody['last_name']);
        $user->setEmail($reqBody['email']);
        $user->setPassword($reqBody['password']);
        $user->setProvider($reqBody['provider']);

        $userDao->save($user);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
