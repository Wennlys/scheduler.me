<?php


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use ReallySimpleJWT\Token;

use Source\Core\Controller;

class SessionController extends Controller
{
    public function store(ServerRequestInterface $request)
    {
        $this->body = json_decode($request->getBody(), true);

            $login = $this->body['login'];
            $password = $this->body['password'];

        if (is_email($login)) {
            $user = ($this->user)->findByEmail($login);
        } else {
            $user = ($this->user)->findByUserName($login);
        }

        if (!$user)
            return $this->encodedWrite("Usuário não encontrado", 401);

        if (!password_verify($password, $user[0]->password))
            return $this->encodedWrite("false");

        return $this->encodedWrite((object)[
            "user" => [
                "id" => $user[0]->id,
                "name" => $user[0]->user_name,
                "email" => $user[0]->email ],
            "token" => Token::create($user[0]->id, JWT_SECRET, JWT_EXPIRATION, JWT_ISSUER)
        ]);
    }
}
