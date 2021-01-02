<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;

class AppointmentIndexAvailableController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        ['date' => $date] = $request->getQueryParams();
        $date = (int)floor($date / 1000.0);
        $date = date("Y-m-d H:i:s", $date);

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setProviderId($args['providerId']);
        $appointment->setDate($date);

        $appointments = $appointmentDao->findByDay($appointment);

        $schedule = [
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00',
            '19:00'
        ];

        $available = array_map(function ($time) use ($date, $appointments) {
            [$day] = (str_split($date, 10));
            $value = "$day $time:00";

            $isAvailable = (date("Y-m-d H:i:s") < $value) &&
                !current(array_filter($appointments ?? [],
                    fn($appointment) =>
                        date_format(date_create($appointment->date), "H:i") === $time));

            return [
                "time" => $time,
                "value" => $value,
                "available" => $isAvailable
            ];
        }, $schedule);

        $this->response->getBody()->write(json_encode($available, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
