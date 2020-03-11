<?php


namespace Source\App;


use Source\Core\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;
use Exception;


/**
 * Class UserController
 *
 * @package Source\App
 */
class UserController extends Controller
{

    /**
     * @return Response|ResponseInterface
     */
    public function index()
    {
        return $this->getRows();
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array|mixed|null
     */
    public function show(ServerRequestInterface $request)
    {
        $this->body = json_decode($request->getBody(), true);

            $login = $this->body['login'];

        if(is_email($login)) {
            $user = ($this->user)->findByEmail($login);
        } else {
            $user = ($this->user)->findByUserName($login);
        }
        $table = $this->user->findById($user[0]->id);
        return $this->encodedWrite($table->data());
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     * @throws Exception
     */
    public function store(ServerRequestInterface $request)
    {
        $this->body = json_decode($request->getBody(), true);

            $this->user->user_name = $this->body['user_name'];
            $this->user->first_name = $this->body['first_name'];
            $this->user->last_name = $this->body['last_name'];
            $this->user->email = $this->body['email'];
            $this->user->password = $this->body['password'];
            $this->user->provider = $this->body['provider'];
            $this->user->save();

        if ($this->user->message) {
            $this->encodedWrite($this->user->message);
            return $this->response->withStatus(400);
        }

        $data = (array)$this->user->data();
        $parsedData = (object)[
            "id" => $this->user->userId,
            "user_name" => $data['user_name'],
            "email" => $data['email'],
            "provider" => $data['provider'],
        ];

        $this->encodedWrite($parsedData);
        return $this->response->withStatus(200);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     */
    public function update(ServerRequestInterface $request)
    {
        $this->body = (array)json_decode($request->getBody());

            $login = $this->body['login'];
            $oldPass = $this->body['old_password'];
            $password = $this->body['password'];

        if ($oldPass === $password) {
            return $this->encodedWrite("Passwords cannot be the same");
        }

        $token = $this->getToken($request);
        $userId = (Token::getPayload($token, JWT_SECRET))['user_id'];
        $user = $this->user->table($userId);;

        $body = [
            "first_name" => $this->body['first_name'],
            "last_name" => $this->body['last_name'],
            "password" => password_hash($this->body['password'], PASSWORD_DEFAULT),
            "provider" => $this->body['provider']
        ];

        if (is_email($login)) {
            $body["email"] = $login;

            if ($user->email !== $login) {
                $userExists = ($this->user)->findByEmail($login);

                if ($userExists) {
                    return $this->encodedWrite("User already exists", 401);
                }
            }
        } else {
            $body["user_name"] = $login;

            if ($user->user_name !== $login) {
                $userExists = ($this->user)->findByUserName($login);

                if ($userExists) {
                    return $this->encodedWrite("User already exists", 401);
                }
            }
        }

        if ($oldPass && !password_verify($oldPass, $user->password)) {
            return $this->encodedWrite("Passwords do not match");
        }

        $changed = $this->user->change($userId, $body);
        return $this->encodedWrite($changed);
    }

    public function destroy(ServerRequestInterface $request)
    {
        $this->body = json_decode($request->getBody(), true);
        return $this->encodedWrite("User");
    }

}
