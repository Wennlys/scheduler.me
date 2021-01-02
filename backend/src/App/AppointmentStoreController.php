<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\Appointment;
use Source\Models\AppointmentDAO;
use Source\Models\User;
use Source\Models\UserDAO;
use Source\Core\MongoConnection;
use Source\Models\NotificationDAO;
use Source\Models\Notification;
use DateTime;
use Exception;

class AppointmentStoreController
{
    private Connection $connection;
    private ResponseInterface $response;
    private MongoConnection $mongoConnection;

    public function __construct(Connection $connection,
                                MongoConnection $mongoConnection,
                                ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->mongoConnection = $mongoConnection;
        $this->response = $response;
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        date_default_timezone_set('America/Sao_Paulo');

        [
            'provider_id' => $providerId,
            'date' => $date
        ] = $request->getQueryParams();

        ['user_id' => $userId] = getPayload($request);

        $userDao = new UserDAO($this->connection);
        $user = new User();

        $user->setUserId($providerId);

        [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'provider' => $isProvider
        ] = (array)$userDao->findById($user);

        if (!$isProvider) {
            $this->response->getBody()->write(
                json_encode("You must only create appointments with providers."));
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
        $date = $date->format('d \d\o m \d\e Y \à\s H:i');

        $notification->setUser($providerId);
        $notification->setContent(
            "Novo agendamento de $firstName $lastName para o dia $date.");
        $notification->setRead(false);
        $notification->setCreatedAt(date('m-d-Y H:i:s', time()));
        $notification->setUpdatedAt(date('m-d-Y H:i:s', time()));
        $notificationDao->save($notification);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
