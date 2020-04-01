<?php declare(strict_types=1);


namespace Source\Models;


/**
 * Class Appointment
 *
 * @package Source\Models
 */
class Appointment
{
    /** @var string $id */
    private string $id;

    /** @var string */
    private string $providerId;

    /** @var string */
    private string $userId;

    /** @var string */
    private string $date;

    /** @var string */
    private string $page;

    /**
     * @return string
     */
    public function getId()
    : string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    : void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getProviderId()
    : string
    {
        return $this->providerId;
    }

    /**
     * @param string $providerId
     */
    public function setProviderId(string $providerId)
    : void {
        $this->providerId = $providerId;
    }

    /**
     * @return string
     */
    public function getUserId()
    : string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId)
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

    /**
     * @return string
     */
    public function getPage()
    : string
    {
        return $this->page;
    }

    /**
     * @param string $page
     */
    public function setPage(string $page)
    : void {
        $this->page = $page;
    }
}
