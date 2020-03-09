<?php


namespace Source\App;


use Source\Core\Controller;
use Psr\Http\Message\ServerRequestInterface;
use Source\Models\User;

class SessionController extends Controller
{
    public function store(ServerRequestInterface $request)
    {
        $this->content = json_decode($request->getBody(), true);

            $login = $this->content['login'];
            $password = $this->content['password'];

        if (is_email($login)) {
            $user = (new User)->findByEmail($login);
        } else {
            $user = (new User)->findByUserName($login);
        }

        if (!$user) {
            $this->response->getBody()->write(json_encode("Usuário não encontrado"));
            return $this->response->withStatus(401);
        }
        password_verify();
        (($this->instance)->query("SELECT * FROM scheduler.users WHERE email = 'wennlys@mail.com' "))->fetchAll();
    }
}
