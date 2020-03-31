<?php


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Source\Core\MongoConnection;

class NotificationIndexController
{
    /** @var MongoConnection */
    private MongoConnection $mongoConnection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    public function __construct(MongoConnection $mongoConnection, ResponseInterface $response)
    {
        $this->mongoConnection = $mongoConnection;
        $this->response = $response;
    }

    public function index(): ResponseInterface
    {
        return $this->response->withStatus(200);
    }
}
