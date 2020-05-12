<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;
use Source\Models\User;
use Source\Models\UserDAO;
use Exception;

/**
 * Class AppointmentIndexScheduleController
 *
 * @package Source\App
 */
class AppointmentIndexScheduleController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * AppointmentIndexScheduleController constructor.
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
     * @throws Exception
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        ['date' => $date] = $request->getQueryParams();
        ['user_id' => $userId] = getPayload($request);

        $user = new User();
        $userDao = new UserDAO($this->connection);

        $user->setUserId($userId);

        $user = $userDao->findProvider($user);

        if (!$user) {
            $this->response->getBody()->write(json_encode("User is not a provider."));
            return $this->response->withStatus(200);
        }

        $appointment = new Appointment();
        $appointmentDao = new AppointmentDAO($this->connection);

        $appointment->setDate(str_replace('+', ' ', $date));
        $appointment->setProviderId($userId);

        $appointments = array_map(function ($appointment) use ($user) {
            return [
                "name" => $user->first_name . " " . $user->last_name,
                $appointment,
            ];
        }, $appointmentDao->findByDay($appointment));

        $this->response->getBody()->write(json_encode($appointments, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
