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

    /**
     * AppointmentStoreController constructor.
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
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $reqBody = json_decode((string)$request->getBody(), true);

        $payload = getPayload($request);
        $userId = $payload['user_id'];

        $userDao = new UserDAO($this->connection);
        $user = new User();

        $user->setUserId($reqBody["provider_id"]);

        $isProvider = ($userDao->findById($user))->provider;

        if (!$isProvider) {
            $this->response->getBody()->write(
                json_encode("You must create appointments with providers.")
            );
            return $this->response->withStatus(400);
        }

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setProviderId($reqBody["provider_id"]);
        $appointment->setDate($reqBody["date"]);
        $appointment->setUserId($userId);

        $appointmentDao->save($appointment);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
