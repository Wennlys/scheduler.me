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
     * @param array                  $args
     *
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, array $args): ResponseInterface
    {
        ["id" => $id] = $args;
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $notification->setId($id);
        $notification->setUser($userId);

        $this->response->getBody()->write(json_encode($notificationDao->update($notification)));
        return $this->response->withStatus(200);
    }
}
