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
        $this->database = new Database($connection, "appointments");
    }

    /**
     * @param Appointment $appointment
     *
     * @return string
     * @throws Exception
     */
    public function save(Appointment $appointment): string
    {
        if ($this->findByDateAndProvider($appointment))
            throw new Exception("Date is not available.");

        return $this->database->create([
            "provider_id" => $appointment->getProviderId(),
            "user_id" => $appointment->getUserId(),
            "date" => $appointment->getDate()
        ]);
    }

    /**
     * @param Appointment $appointment
     *
     * @return bool
     * @throws Exception
     */
    public function cancel(Appointment $appointment)
    {
        return $this->database->update(["canceled_at" => date('Y-m-d H:i:s', time())],
                                        "id = :id", "id={$appointment->getId()}");
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findByProvider(Appointment $appointment)
    {
        return $this->database
            ->find("*", "provider_id = :id", "id={$appointment->getProviderId()}")
            ->fetch(true);
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findByUserId(Appointment $appointment)
    {
        return $this->database
            ->find("*", "user_id = :id", "id={$appointment->getUserId()}")
            ->fetch(true);
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findById(Appointment $appointment)
    {
        return $this->database
            ->find("*", "id = :id", "id={$appointment->getId()}")
            ->fetch();
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|null
     */
    public function findAppointments(Appointment $appointment): ?array
    {
        $page = $appointment->getPage();
        return $this->database
            ->find("appointments.id id, appointments.date,
                              users.id user, users.first_name, users.last_name,
                              files.id avatar, files.path")
            ->join("appointments.user_id = users.id", "users")
            ->and("appointments.user_id = {$appointment->getUserId()}")
            ->join("users.avatar_id = files.id", "files")
            ->limit(20)
            ->offset(($page - 1)*20)
            ->fetch(true);
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findByDateAndProvider(Appointment $appointment)
    {
        $date = (str_split($appointment->getDate(), 14))[0];
        return $this->database
            ->find("*",
                   "date like '{$date}%'")
            ->and("provider_id = {$appointment->getProviderId()}")
            ->fetch(true);
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findByDay(Appointment $appointment)
    {
        $date = (str_split($appointment->getDate(), 14))[0];
        return $this->database
            ->find("*",
                "provider_id = :id", ":id={$appointment->getProviderId()}")
            ->and("date like '{$date}%'")
            ->and("canceled_at is null")
            ->fetch(true);
    }
}


