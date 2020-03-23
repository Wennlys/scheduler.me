<?php declare(strict_types=1);


namespace Source\Models\Interfaces;


use Source\Models\User;

interface UserDaoInterface
{
    public function save(User $user): bool;
    public function update(User $user, string $currentPass, string $id): bool;
    public function delete(string $id, string $currentPass): bool;
    public function findByLogin(string $login): ?object;
    public function findById(string $id): ?object;
    public function findAll(): ?array;
}
