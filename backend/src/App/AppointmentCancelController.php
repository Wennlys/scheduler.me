<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;
use Exception;

class AppointmentCancelController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function cancel(ServerRequestInterface $request, array $args): ResponseInterface
    {
        ['user_id' => $userId] = getPayload($request);

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setId($args['id']);
        $appointment->setUserId($userId);

        $appointmentDao->cancel($appointment);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
