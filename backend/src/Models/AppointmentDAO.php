<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;
use Source\Core\Connection;
use Exception;

/**
 * Class AppointmentDAO
 *
 * @package Source\Models
 */
class AppointmentDAO
{
    /** @var Database*/
    private Database $database;

    /**
     * AppointmentDAO constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection, "appointments", ["date"]);
    }

    /**
     * @param Appointment $appointment
     *
     * @return bool
     * @throws Exception
     */
    public function save(Appointment $appointment): bool
    {
        return $this->database->create(
            [
                "provider_id" => $appointment->getProviderId(),
                "user_id" => $appointment->getUserId(),
                "date" => $appointment->getDate()
            ]
        );
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function findAppointments(int $userId): ?array
    {
        return $this->database->find("user_id = :id, canceled_at = null", "id = {$userId}")->fetch
        (true);
    }
}
