<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\MongoConnection;
use Source\Models\Notification;
use Source\Models\NotificationDAO;
use Source\Models\User;
use Source\Models\UserDAO;
use Source\Core\Connection;

class NotificationProviderIndexController
{
    private MongoConnection $mongoConnection;
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection,
                                MongoConnection $mongoConnection,
                                ResponseInterface $response)
    {
        $this->mongoConnection = $mongoConnection;
        $this->connection = $connection;
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request): ResponseInterface {
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $userDao = new UserDAO($this->connection);
        $user = new User();

        $user->setUserId($userId);

        if (!$userDao->findProvider($user)) {
            $this->response->getBody()->write(json_encode(
                "User must be a provider to list notifications."));
            return $this->response->withStatus(400);
        }

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $notification->setUser($userId);

        $this->response->getBody()->write(json_encode($notificationDao->findByProvider($notification)));
        return $this->response->withStatus(200);
    }
}
