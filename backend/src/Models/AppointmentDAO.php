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
    /** @var string $id */
    private string $id;

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
     * @return array
     * @throws Exception
     */
    public function save(Appointment $appointment): array
    {
        $userId = $appointment->getUserId();
        $providerId = $appointment->getProviderId();
        $date = $appointment->getDate();

        if ($userId === $providerId)
            throw new Exception("User and provider cannot be the same.");

        if ($this->findByDay($appointment))
            throw new Exception("Date is not available.");

        $this->id = $this->database->create([
            "provider_id" => $providerId,
            "user_id" => $userId,
            "date" => $date
        ]);

        return (array)$this->findById();
    }

    /**
     * @param Appointment $appointment
     *
     * @return bool
     * @throws Exception
     */
    public function cancel(Appointment $appointment)
    {
        [
            "user_id" => $appointmentUserId,
            "date" => $appointmentDate,
        ] = (array)$this->findById($appointment);

        $date = date_create(date("Y-m-d H:i:s"));
        $appointmentDate = date_create($appointmentDate);

        $difference = date_diff($appointmentDate, $date)->h;

        if ($difference <= 2)
            throw new Exception("You can only cancel an appointment with two hours in advance.");

        if (!$appointmentUserId)
            throw new Exception("Not existing appointment.");

        if ($appointment->getUserId() !== $appointmentUserId)
            throw  new Exception("User does not have permission to cancel this appointment.");

        return $this->database->update(
            ["canceled_at" => date("Y-m-d H:i:s", time())],
            "id = :id",
            "id={$appointment->getId()}");
    }

    /**
     * @param Appointment $appointment
     *
     * @return array|mixed|null
     */
    public function findById(?Appointment $appointment = null)
    {
        $id = $appointment ? $appointment->getId() : $this->id;

        return $this->database
            ->find("*",
                   "id = :id",
                   "id=$id")
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
    public function findByDay(Appointment $appointment)
    {
        [$date] = (str_split($appointment->getDate(), 10));
        return $this->database
            ->find("*",
                "provider_id = :id", ":id={$appointment->getProviderId()}")
            ->and("date like '{$date}%'")
            ->and("canceled_at is null")
            ->fetch(true);
    }
}


