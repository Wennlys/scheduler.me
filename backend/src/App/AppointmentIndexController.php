<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;

/**
 * Class AppointmentIndexController
 *
 * @package Source\App
 */
class AppointmentIndexController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * AppointmentIndexController constructor.
     *
     * @param Connection        $connection
     * @param ResponseInterface $response
     */
    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        ['page' => $page] = $request->getQueryParams();
        ['user_id' => $userId] = getPayload($request);

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setUserId($userId);
        $appointment->setPage($page);

        $appointments = $appointmentDao->findAppointments($appointment);

        foreach ($appointments as $item) {
            $responseBody[] = [
                "id" => $item->id,
                "date" => $item->date,
                "past" =>
                    date_format(date_create($item->date), "Y-m-d H:i:s") < date("Y-m-d H:i:s"),
                "provider" => [
                    "id" => $item->user,
                    "name" => $item->first_name . " " . $item->last_name,
                    "avatar" => [
                        "id" => $item->avatar,
                        "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/{$item->path}",
                    ]
                ]
            ];
        }
        $this->response->getBody()->write(json_encode($responseBody ?? [], JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
