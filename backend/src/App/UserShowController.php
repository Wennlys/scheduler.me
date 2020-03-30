<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;
use Source\Models\User;
use Exception;


class UserShowController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection */
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
     * @throws Exception
     */
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

        $row = $userDao->findByLogin($user);

        $this->response->getBody()->write(json_encode($row));
        return $this->response->withStatus(200);
    }
}
