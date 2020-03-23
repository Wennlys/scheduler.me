<?php declare(strict_types=1);


namespace Source\Models;


use Exception;

class User
{
    private ?string $user_name = null;
    private ?string $first_name = null;
    private ?string $last_name = null;
    private ?string $email = null;
    private ?string $password = null;
    private bool $provider;

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
     * @return bool
     */
    public function getProvider()
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
