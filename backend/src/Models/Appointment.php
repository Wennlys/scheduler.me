<?php 
declare(strict_types=1);

namespace Source\Models;

class Appointment
{
    private string $id;
    private string $providerId;
    private string $userId;
    private string $date;
    private string $page;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getProviderId(): string
    {
        return $this->providerId;
    }

    public function setProviderId(string $providerId): void {
        $this->providerId = $providerId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void {
        $this->userId = $userId;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function setPage(string $page): void {
        $this->page = $page;
    }
}
