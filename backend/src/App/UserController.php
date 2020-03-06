<?php


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Source\Models\User;
use Psr\Http\Message\ResponseInterface;


/**
 * Class UserController
 *
 * @package Source\App
 */
class UserController
{
    /**
     * @var array
     */
    private array $content;
    /**
     * @var User
     */
    private User $user;
    /**
     * @var Response
     */
    private Response $response;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user = new User();
        $this->response = new Response();
    }


    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface|string
     */
    public function store(ServerRequestInterface $request)
    {
        $this->content = json_decode($request->getBody(), true);

        try {
            $this->user->user_name = $this->content['user_name'];
            $this->user->first_name = $this->content['first_name'];
            $this->user->last_name = $this->content['last_name'];
            $this->user->email = $this->content['email'];
            $this->user->password_hash = $this->content['password_hash'];
            $this->user->provider = $this->content['provider'];
            $this->user->save();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        $this->response->getBody()->write("true");

        return $this->response->withAddedHeader('content-type', 'application/json')->withStatus(200);
    }

}
