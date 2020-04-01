<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\AppointmentDAO;
use Source\Models\Appointment;

/**
 * Class AppointmentDestroyController
 *
 * @package Source\App
 */
class AppointmentDestroyController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    /**
     * AppointmentDestroyController constructor.
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
     * @param array                  $args
     *
     * @return ResponseInterface
     */
    public function destroy(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $payload = getPayload($request);
        $userId = $payload["user_id"];

        $appointmentDao = new AppointmentDAO($this->connection);
        $appointment = new Appointment();

        $appointment->setId($args["id"]);
        $appointment->setUserId($userId);

        if (!$appointmentDao->findByUserId($appointment)) {
            $this->response->getBody()->write(json_encode(
                "User does not have permission to cancel this appointment."));
            return $this->response->withStatus(200);
        }

        $appointmentDao->delete($appointment);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
