<?php


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Source\Models\User;
use Psr\Http\Message\ResponseInterface;
use Exception;
use Source\Core\Connection;


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
     * REGISTER
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface|string|array
     * @throws Exception
     */
    public function store(ServerRequestInterface $request)
    {
        $this->content = filter_var_array(json_decode($request->getBody(), true),
                                    FILTER_SANITIZE_STRIPPED);

        try {
            $this->user->user_name = $this->content['user_name'];
            $this->user->first_name = $this->content['first_name'];
            $this->user->last_name = $this->content['last_name'];
            $this->user->email = $this->content['email'];
            $this->user->password = $this->content['password'];
            $this->user->provider = $this->content['provider'];
            $this->user->save();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
        $this->response->getBody()->write(json_encode($this->user->message ?
            $this->user->message :" true "));
        $this->response->getBody()->write(json_encode($this->user->id));

        return $this->response->withAddedHeader('content-type', 'application/json')->withStatus(200);

    }

    public function show() {
        $results = $this->user->find()->fetch();
        $this->response->getBody()->write(json_encode($results));
        return $this->response->withAddedHeader('content-type', 'application/json')->withStatus(200);
    }

}
