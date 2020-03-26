<?php declare(strict_types=1);


namespace Source\Models;


use Source\Core\Database;
use Source\Core\Connection;

use Exception;


/**
 * Class UserDAO
 *
 * @package Source\Models
 */
class UserDAO
{
    /** @var Database */
    private Database $database;

    /**
     * UserDAO constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->database = new Database($connection,"users", ["user_name", "last_name", "first_name", "email",
         "password", "provider"]);
    }

    /**
     * @param User $user
     *
     * @return string
     * @throws Exception
     */
    public function save(User $user): string
    {
        return $this->database->create([
            "user_name" => $user->getUserName(),
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "provider" => $user->getProvider()
        ]);
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws Exception
     */
    public function update(User $user): bool
    {
        $id = $user->getUserId();

        if ($user->getEmail() || $user->getPassword() || $user->getUserName()) {
            if (!$this->verifyPassword($user)) {
                throw new Exception("Wrong password.");
            }

            if ($user->getEmail()) {
                if ($this->findByLogin($user->getEmail())) {
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

        return $this->database->update($body, "id = :id", "id={$id}");
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
        $id = $user->getUserId();
        $currentPass = $user->getCurrentPassword();
        $savedPass = ($this->findById($id))->password;

        if (!password_verify($currentPass, $savedPass))
            return false;
        return true;
    }

    /**
     * @param string $login
     *
     * @return object
     */
    public function findByLogin(string $login): ?object
    {
        if (is_email($login)){
            return $this->database->find("email = :e", "e={$login}")->fetch();
        }
        return $this->database->find("user_name = :u", "u={$login}")->fetch();
    }

    /**
     * @param string $id
     *
     * @return object
     */
    public function findById(string $id): ?object
    {
        return $this->database->find("id = :id", "id={$id}")->fetch();
    }

    /**
     * @return array
     */
    public function findAll(): ?array
    {
        return $this->database->find()->fetch(true);
    }
}
