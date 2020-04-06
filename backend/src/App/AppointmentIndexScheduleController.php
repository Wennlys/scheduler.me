<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;
use Source\Models\User;
use Source\Models\UserDAO;

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
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $date = ($request->getQueryParams())['date'];

        $payload = getPayload($request);
        $userId = $payload['user_id'];

        $user = new User();
        $userDao = new UserDAO($this->connection);

        $user->setUserId($userId);

        if (!$userDao->findProvider($user)) {
            $this->response->getBody()->write(json_encode("User is not a provider."));
            return $this->response->withStatus(200);
        }

        $appointment = new Appointment();
        $appointmentDao = new AppointmentDAO($this->connection);

        $appointment->setDate($date);
        $appointment->setProviderId($userId);

        $responseBody = $appointmentDao->findByDay($appointment);

        $this->response->getBody()->write(json_encode($responseBody, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
