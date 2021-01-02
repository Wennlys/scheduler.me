<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;

class AppointmentIndexController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        ['page' => $page] = $request->getQueryParams();
        ['user_id' => $userId] = getPayload($request);

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setUserId($userId);
        $appointment->setPage($page);

        $appointments = array_map(function ($appointment) {
            return [
                "id" => $appointment->id,
                "date" => $appointment->date,
                "past" =>
                    date_format(date_create($appointment->date), "Y-m-d H:i:s") < date("Y-m-d H:i:s"),
                "provider" => [
                    "id" => $appointment->user,
                    "name" => $appointment->first_name . " " . $appointment->last_name,
                    "avatar" => [
                        "id" => $appointment->avatar,
                        "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/{$appointment->path}",
                    ]
                ]
            ];
        }, $appointmentDao->findAppointments($appointment));

        $this->response->getBody()->write(json_encode($appointments, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
