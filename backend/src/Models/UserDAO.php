<?php declare(strict_types=1);


namespace Source\Models;

use Source\Core\Connection;
use Source\Core\Database;
use Exception;

/**
 * Class UserDAO
 *
 * @package Source\Models
 */
class UserDAO
{
    /** @var string $id */
    private string $id;

    /** @var Database */
    private Database $database;

    /**
     * UserDAO constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection,"users");
    }

    /**
     * @param User $user
     *
     * @return array
     * @throws Exception
     */
    public function save(User $user): array
    {
        $this->id = $this->database->create([
            "user_name" => $user->getUserName(),
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "provider" => $user->isProvider()
        ]);

        return (array)$this->findById();
    }

    /**
     * @param User $user
     *
     * @return array
     * @throws Exception
     */
    public function update(User $user): array
    {
        $this->id = $user->getUserId();

        if ($user->getEmail() || $user->getPassword() || $user->getUserName()) {
            if (!$this->verifyPassword($user)) {
                throw new Exception("Wrong password.");
            }

            if ($user->getEmail()) {
                if ($this->findByLogin($user)) {
                    throw new Exception("Email already in use.");
                }
            }
        }

        $body = array_filter([
          "user_name" => $user->getUserName(),
          "first_name" => $user->getFirstName(),
          "last_name" => $user->getLastName(),
          "email" => $user->getEmail(),
          "password" => $user->getPassword(),
          "avatar_id" => $user->getAvatarId()
        ]);

        $this->database->update($body, "id = :id", "id=$this->id");

        return (array)$this->findById();
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws Exception
     */
    public function delete(User $user): bool
    {
        $id = $user->getUserId();

        if (!$this->verifyPassword($user))
            throw new Exception("Wrong password.");

        return $this->database->delete("id = :id", "id={$id}");
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws Exception
     */
    public function verifyPassword(User $user): bool
    {
        $currentPass = $user->getCurrentPassword();
        $savedPass = ($this->findById($user))->password;

        if (!password_verify($currentPass, $savedPass))
            return false;
        return true;
    }

    /**
     * @param User $user
     *
     * @return object
     */
    public function findByLogin(User $user): ?object
    {
        if ($user->getEmail()) {
            return $this->database->find("*, users.id id")
                ->join("users.avatar_id = files.id", "files")
                ->and("email='{$user->getEmail()}'")
                ->fetch();
        }
        return $this->database->find("*, users.id id")
            ->join("users.avatar_id = files.id", "files")
            ->and("user_name='{$user->getUserName()}'")
            ->fetch();

//        return $this->database
//            ->find("users.id, users.first_name, users.last_name, users.email, files.name, files.path")
//            ->join("users.avatar_id = files.id", "files")
//            ->order("id")
//            ->fetch(true);
    }

    /**
     * @param User|null $user
     *
     * @return object
     */
    public function findById(?User $user = null): ?object
    {
        $id = $user ? $user->getUserId() : $this->id;

        return $this->database->find("*, users.id id")
            ->join("users.avatar_id = files.id", "files")
            ->and("users.id = $id")
            ->fetch();
    }

    /**
     * @return array
     */
    public function findAll(): ?array
    {
        return $this->database->find()->fetch(true);
    }

    /**
     * @return array|mixed|null
     */
    public function findAllProviders()
    {
        return $this->database
            ->find("users.id, users.first_name, users.last_name, users.email, files.name, files.path")
            ->join("users.avatar_id = files.id", "files")
            ->order("id")
            ->fetch(true);
    }

    /**
     * @param User $user
     *
     * @return array|mixed|null
     */
    public function findProvider(User $user)
    {
        return $this->database
            ->find("*",
                   "id = :id",
                   "id={$user->getUserId()}")
            ->and("provider = true")
            ->fetch();
    }
}
