<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\MongoConnection;
use Source\Models\Notification;
use Source\Models\NotificationDAO;

/**
 * Class NotificationProviderUpdateController
 *
 * @package Source\App
 */
class NotificationProviderUpdateController
{
    /** @var MongoConnection */
    private MongoConnection $mongoConnection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /**
     * NotificationProviderUpdateController constructor.
     *
     * @param MongoConnection   $mongoConnection
     * @param ResponseInterface $response
     */
    public function __construct(MongoConnection $mongoConnection, ResponseInterface $response)
    {
        $this->mongoConnection = $mongoConnection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $notification->setUser($userId);

        $reqBody = $notificationDao->update($notification);

        $this->response->getBody()->write(json_encode($reqBody));
        return $this->response->withStatus(200);
    }
}
