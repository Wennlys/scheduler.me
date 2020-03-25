<?php


namespace Source\App;


use Source\Core\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Models\Appointment;
use Source\Models\AppointmentDAO;
use ReallySimpleJWT\Token;

/**
 * Class AppointmentController
 *
 * @package Source\App
 */
class AppointmentController
{
    /** @var Connection */
    private Connection $connection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /**
     * AppointmentController constructor.
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
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $reqBody = json_decode((string)$request->getBody(), true);

        $payload = Token::getPayload(getToken($request), JWT_SECRET);
        $userId = $payload['user_id'];

        $appointment = new Appointment();

            $appointment->setProviderId($reqBody["provider_id"]);
            $appointment->setUserId($userId);
            $appointment->setDate($reqBody["date"]);

        $appointmentDao = new AppointmentDAO($this->connection);

        $appointmentDao->save($appointment);

        return $this->response->withStatus(200);
    }
}
