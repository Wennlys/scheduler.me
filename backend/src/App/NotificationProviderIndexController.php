<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\MongoConnection;
use Source\Models\Notification;
use Source\Models\NotificationDAO;
use Source\Models\User;
use Source\Models\UserDAO;
use Source\Core\Connection;

/**
 * Class NotificationProviderIndexController
 *
 * @package Source\App
 */
class NotificationProviderIndexController
{
    /** @var MongoConnection */
    private MongoConnection $mongoConnection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    /**
     * NotificationProviderIndexController constructor.
     *
     * @param MongoConnection   $mongoConnection
     * @param Connection        $connection
     * @param ResponseInterface $response
     */
    public function __construct(MongoConnection $mongoConnection,
                                Connection $connection,
                                ResponseInterface $response)
    {
        $this->mongoConnection = $mongoConnection;
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request)
    : ResponseInterface {
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $userDao = new UserDAO($this->connection);
        $user = new User();

        $user->setUserId($userId);

        if ($userDao->findProvider($user)) {
            $this->response->getBody()->write(json_encode(
                "User must be a provider to list notifications."));
            return $this->response->withStatus(200);
        }

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $notification->setUser($userId);

        $this->response->getBody()->write(json_encode($notificationDao->findByProvider($notification)));
        return $this->response->withStatus(200);
    }
}
