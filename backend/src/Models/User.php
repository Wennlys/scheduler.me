<?php 
declare(strict_types=1);

namespace Source\Models;

use Exception;

class User
{
    private ?string $user_id = null;
    private ?string $user_name = null;
    private ?string $first_name = null;
    private ?string $last_name = null;
    private ?string $email = null;
    private ?string $currentPassword = null;
    private ?string $password = null;
    private ?string $avatar_id = null;
    private bool $provider;

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(?string $user_id): void {
        $this->user_id = $user_id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): void {
        if (empty($user_name))
            throw new Exception("User name cannot be empty.");
        $this->user_name = filter_var($user_name, DEFAULT_FILTER);
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void {
        if (empty($first_name))
            throw new Exception("First name cannot be empty.");
        $this->first_name = filter_var($first_name, DEFAULT_FILTER);
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void {
        if (empty($last_name))
            throw new Exception("Last name cannot be empty.");
        $this->last_name = filter_var($last_name, DEFAULT_FILTER);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void {
        if (empty($email))
            throw new Exception("Email cannot be empty.");
        if (!is_email($email))
            throw new Exception("Not valid email address.");
        $this->email = filter_var($email, DEFAULT_FILTER);
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(?string $currentPassword): void {
        $this->currentPassword = $currentPassword;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void {
        if (!is_password($password))
            throw new Exception("Password must be between " . MIN_PASS_LEN . " and " .
                                MAX_PASS_LEN . " characters");
        $this->password = password_hash($password, PASS_ALGO);
    }

    public function getAvatarId(): ?string
    {
        return $this->avatar_id;
    }

    public function setAvatarId(?string $avatar_id): void {
        $this->avatar_id = $avatar_id;
    }

    public function isProvider(): bool
    {
        return $this->provider;
    }

    public function setProvider(bool $provider): void {
        if (empty($provider))
            $this->provider = false;
        $this->provider = $provider;
    }
}
