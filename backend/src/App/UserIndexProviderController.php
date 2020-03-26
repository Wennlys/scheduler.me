<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;
use Source\Models\FileDAO;

class UserIndexProviderController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserIndexProviderController constructor.
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
        $fileDao = new FileDAO($this->connection);

        $responseBody = [];


        $this->response->getBody()->write(json_encode((object)$responseBody));
        return $this->response->withStatus(200);
    }
}