<?php declare(strict_types=1);


namespace Source\App;


use Source\Core\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;

/**
 * Class SessionController
 *
 * @package Source\App
 */
class SessionController extends Controller
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     */
    public function store(ServerRequestInterface $request): Response
    {
        $this->body = json_decode($request->getBody(), true);

            $login = $this->body['login'];
            $password = $this->body['password'];

        $user = $this->userDao->findByLogin($login);

        if (!$user)
            return $this->encodedWrite("Usuário não encontrado", 401);

        if (!password_verify($password, $user->password))
            return $this->encodedWrite("false");

        return $this->encodedWrite((object)[
            "user" => [
                "id" => $user->id,
                "name" => $user->user_name,
                "email" => $user->email ],
            "token" => Token::create($user->id, JWT_SECRET, JWT_EXPIRATION, JWT_ISSUER)
        ]);
    }
}
