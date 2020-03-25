<?php declare(strict_types=1);


namespace Source\Models;


/**
 * Class Appointment
 *
 * @package Source\Models
 */
class Appointment
{
    /** @var int */
    private int $providerId;

    /** @var int */
    private int $userId;

    /** @var string */
    private string $date;

    /**
     * @return int
     */
    public function getProviderId()
    : int
    {
        return $this->providerId;
    }

    /**
     * @param int $providerId
     */
    public function setProviderId(int $providerId)
    : void {
        $this->providerId = $providerId;
    }

    /**
     * @return int
     */
    public function getUserId()
    : int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    : void {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getDate()
    : string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date)
    : void {
        $this->date = $date;
    }
}
