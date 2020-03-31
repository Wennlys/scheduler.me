<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Exception;
use Source\Core\Connection;
use Source\Models\Appointment;
use Source\Models\AppointmentDAO;
use Source\Models\User;
use Source\Models\UserDAO;
use Source\Core\MongoConnection;
use Source\Models\NotificationDAO;
use Source\Models\Notification;
use DateTime;

/**
 * Class AppointmentStoreController
 *
 * @package Source\App
 */
class AppointmentStoreController
{
    /** @var Connection */
    private Connection $connection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var MongoConnection */
    private MongoConnection $mongoConnection;

    /**
     * AppointmentStoreController constructor.
     *
     * @param Connection        $connection
     * @param MongoConnection   $mongoConnection
     * @param ResponseInterface $response
     */
    public function __construct(Connection $connection,
                                MongoConnection $mongoConnection,
                                ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->mongoConnection = $mongoConnection;
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
        date_default_timezone_set('America/Sao_Paulo');

        $reqBody = json_decode((string)$request->getBody(), true);

        $payload = getPayload($request);

        $userId = $payload["user_id"];
        $providerId = $reqBody["provider_id"];

        if ($userId === $providerId) {
            $this->response->getBody()->write(
                json_encode("User and provider cannot be the same.")
            );
            return $this->response->withStatus(400);
        }

        $date = $reqBody["date"];

        $userDao = new UserDAO($this->connection);
        $user = new User();

        $user->setUserId($providerId);

        $userInfos = $userDao->findById($user);

        $userFullName = "{$userInfos->first_name} {$userInfos->last_name}";
        $isProvider = $userInfos->provider;

        if (!$isProvider) {
            $this->response->getBody()->write(
                json_encode("You must create appointments with providers.")
            );
            return $this->response->withStatus(400);
        }

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setProviderId($providerId);
        $appointment->setDate($date);
        $appointment->setUserId($userId);

        $appointmentDao->save($appointment);

        $notificationDao = new NotificationDAO($this->mongoConnection);
        $notification = new Notification();

        $date = new DateTime($date);
        $date = $date->format('d \d\e m \d\e Y \à\s H:i ');

        $notification->setUser($providerId);
        $notification->setContent("Novo agendamento de $userFullName para o dia $date");
        $notification->setRead(false);
        $notification->setCreatedAt(date('m-d-Y H:i:s', time()));
        $notification->setUpdatedAt(date('m-d-Y H:i:s', time()));
        $notificationDao->save($notification);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
