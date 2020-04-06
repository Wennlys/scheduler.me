<?php declare(strict_types=1);


namespace Source\Models;

/**
 * Class Notification
 *
 * @package Source\Models
 */
class Notification
{
    /** @var string $content*/
    private string $content;

    /** @var string $user*/
    private string $user;

    /** @var bool $read*/
    private bool $read;

    /** @var string $created_at*/
    private string $created_at;

    /** @var string $updated_at*/
    private string $updated_at;

    /**
     * @return string
     */
    public function getContent()
    : string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    : void {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getUser()
    : string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user)
    : void {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function isRead()
    : bool
    {
        return $this->read;
    }

    /**
     * @param bool $read
     */
    public function setRead(bool $read)
    : void {
        $this->read = $read;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    : string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at)
    : void {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    : string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at)
    : void {
        $this->updated_at = $updated_at;
    }
}
