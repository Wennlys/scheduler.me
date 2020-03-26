<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;

class UserIndexController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserIndexController constructor.
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
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);

        $this->response->getBody()->write(json_encode($userDao->findAll()));
        return $this->response->withStatus(200);
    }
}
