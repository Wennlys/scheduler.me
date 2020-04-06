<?php declare(strict_types=1);


namespace Source\Models;

use Exception;

/**
 * Class User
 *
 * @package Source\Models
 */
class User
{
    /** @var string|null $user_id*/
    private ?string $user_id = null;

    /** @var string|null $user_name*/
    private ?string $user_name = null;

    /** @var string|null $first_name*/
    private ?string $first_name = null;

    /** @var string|null $last_name*/
    private ?string $last_name = null;

    /** @var string|null $email*/
    private ?string $email = null;

    /** @var string|null $currentPassword*/
    private ?string $currentPassword = null;

    /** @var string|null $password*/
    private ?string $password = null;

    /** @var string|null $avatar_id*/
    private ?string $avatar_id = null;

    /** @var bool $provider*/
    private bool $provider;

    /**
     * @return string|null
     */
    public function getUserId()
    : ?string
    {
        return $this->user_id;
    }

    /**
     * @param string|null $user_id
     */
    public function setUserId(?string $user_id)
    : void {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUserName()
    : ?string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     *
     * @throws Exception
     */
    public function setUserName(string $user_name)
    : void {
        if (empty($user_name))
            throw new Exception("User name cannot be empty.");
        $this->user_name = filter_var($user_name, DEFAULT_FILTER);
    }

    /**
     * @return string
     */
    public function getFirstName()
    : ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     *
     * @throws Exception
     */
    public function setFirstName(string $first_name)
    : void {
        if (empty($first_name))
            throw new Exception("First name cannot be empty.");
        $this->first_name = filter_var($first_name, DEFAULT_FILTER);
    }

    /**
     * @return string
     */
    public function getLastName()
    : ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     *
     * @throws Exception
     */
    public function setLastName(string $last_name)
    : void {
        if (empty($last_name))
            throw new Exception("Last name cannot be empty.");
        $this->last_name = filter_var($last_name, DEFAULT_FILTER);
    }

    /**
     * @return string
     */
    public function getEmail()
    : ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @throws Exception
     */
    public function setEmail(string $email)
    : void {
        if (empty($email))
            throw new Exception("Email cannot be empty.");
        if (!is_email($email))
            throw new Exception("Not valid email address.");
        $this->email = filter_var($email, DEFAULT_FILTER);
    }

    /**
     * @return string|null
     */
    public function getCurrentPassword()
    : ?string
    {
        return $this->currentPassword;
    }

    /**
     * @param string|null $currentPassword
     */
    public function setCurrentPassword(?string $currentPassword)
    : void {
        $this->currentPassword = $currentPassword;
    }

    /**
     * @return string
     */
    public function getPassword()
    : ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @throws Exception
     */
    public function setPassword(string $password)
    : void {
        if (!is_password($password))
            throw new Exception("Password must be between " . MIN_PASS_LEN . " and " .
                                MAX_PASS_LEN . " characters");
        $this->password = password_hash($password, PASS_ALGO);
    }

    /**
     * @return string|null
     */
    public function getAvatarId()
    : ?string
    {
        return $this->avatar_id;
    }

    /**
     * @param string|null $avatar_id
     */
    public function setAvatarId(?string $avatar_id)
    : void {
        $this->avatar_id = $avatar_id;
    }

    /**
     * @return bool
     */
    public function isProvider()
    : bool
    {
        return $this->provider;
    }

    /**
     * @param bool $provider
     */
    public function setProvider(bool $provider)
    : void {
        if (empty($provider))
            $this->provider = false;
        $this->provider = $provider;
    }
}
