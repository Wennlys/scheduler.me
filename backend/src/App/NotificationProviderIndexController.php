<?php


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Source\Core\MongoConnection;
use Source\Models\Notification;
use Psr\Http\Message\ServerRequestInterface;
use Source\Models\NotificationDAO;

class NotificationProviderIndexController
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

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $notification->setUser($userId);

        $reqBody = $notificationDao->findByProvider($notification);

        $this->response->getBody()->write(json_encode($reqBody));
        return $this->response->withStatus(200);
    }
}
