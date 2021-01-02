<?php 
declare(strict_types=1);

namespace Source\Models;

class Notification
{
    private string $id;
    private string $content;
    private string $user;
    private bool $read;
    private string $created_at;
    private string $updated_at;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void {
        $this->user = $user;
    }

    public function isRead(): bool
    {
        return $this->read;
    }

    public function setRead(bool $read): void {
        $this->read = $read;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void {
        $this->updated_at = $updated_at;
    }
}
