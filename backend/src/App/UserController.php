<?php


namespace Source\App;


use Source\Core\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;


/**
 * Class UserController
 *
 * @package Source\App
 */
class UserController extends Controller
{

    public function index() {
        $this->response->getBody()->write(json_encode($this->getRows()));
        return $this->response->withStatus(200);
    }

    public function show() {

       $this->response->getBody()->write(json_encode(($this->user)->find()->fetch(true)));
        return $this->response->withStatus(200);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     */
    public function store(ServerRequestInterface $request)
    {
        $this->content = json_decode($request->getBody(), true);

            $this->user->user_name = $this->content['user_name'];
            $this->user->first_name = $this->content['first_name'];
            $this->user->last_name = $this->content['last_name'];
            $this->user->email = $this->content['email'];
            $this->user->password = $this->content['password'];
            $this->user->provider = $this->content['provider'];
            $this->user->save();

        if ($this->user->message) {
            $this->response->getBody()->write(json_encode($this->user->message));
            return $this->response->withStatus(400);
        }

        $data = (array)$this->user->data();
        $parsedData = (object)[
            "id" => $this->user->userId,
            "user_name" => $data['user_name'],
            "email" => $data['email'],
            "provider" => $data['provider'],
        ];

        $this->response->getBody()->write(json_encode($parsedData));
        return $this->response->withStatus(200);
    }

    public function update(ServerRequestInterface $request) {
        $this->response->getBody()->write((string)$request->getBody());
        return $this->response->withStatus(200);
    }

    public function destroy() {

    }

}
