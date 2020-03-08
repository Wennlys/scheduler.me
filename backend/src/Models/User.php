<?php


namespace Source\Models;


use Source\Core\Model;

/**
 * Class User
 *
 * @property mixed user_name
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed email
 * @property mixed password
 * @property mixed provider
 *
 * @package Source\Models
 */
class User extends Model
{
    /**
     * @var string
     */
    public ?string $message = null;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["user_name", "first_name", "last_name", "email",
            "password", "provider"]);
    }

    public function save()
    : bool
    {
        if (!$this->required()) {
            $this->message ="Nome, sobrenome, email e senha são obrigatórios";
            return false;
        }

        if (!is_email($this->email)) {
            $this->message ="O e-mail informado não tem um formato válido";
            return false;
        }

        if (!is_password($this->password)) {
            $min = MIN_PASS_LEN;
            $max = MAX_PASS_LEN;
            $this->message ="A senha deve ter entre {$min} e {$max} caracteres";
            return false;
        } else {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        if(is_null($this->provider)) {
            $this->message = "Ainda tá nulo";
            return false;

        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message ="O e-mail informado já está cadastrado";
                return false;
            }

              $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message = $this->fail()->getMessage() ? $this->fail()->getMessage() : null;
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }

    /**
     * @param string $email
     * @param string $columns
     *
     * @return string
     */
    public function findByEmail(string $email, string $columns = "*")
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch(true);
    }
}
