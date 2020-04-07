<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;
use Source\Core\Connection;
use Source\Models\User;
use Source\Models\UserDAO;
use Exception;

/**
 * Class SessionStoreController
 *
 * @package Source\App
 */
class SessionStoreController
{
    /** @var Connection */
    private Connection $connection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /**
     * SessionStoreController constructor.
     *
     * @param Connection        $connection
     * @param ResponseInterface $response
     */
    public function __construct(Connection $connection, ResponseInterface
    $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     * @throws Exception
     */
    public function store(ServerRequestInterface $request): Response
    {
        [
            'login' => $login, 'password' => $password,
        ] = json_decode((string)$request->getBody(), true);

        $userDao = new UserDAO($this->connection);
        $user = new User();

        if (is_email($login)) {
            $user->setEmail($login);
        } else {
            $user->setUserName($login);
        }

        $user = $userDao->findByLogin($user);

        if (!$user) {
            $this->response->getBody()->write(json_encode("User not found."));
            return $this->response->withStatus(200);
        }

        if (!password_verify($password, $user->password)) {
            $this->response->getBody()->write(json_encode("Wrong password."));
            return $this->response->withStatus(401);
        }

        $responseBody = [
            "user" => [
                "id" => $user->id,
                "name" => $user->user_name,
                "email" => $user->email,
            ],
            "token" => Token::create(
                $user->id,
                JWT_SECRET,
                JWT_EXPIRATION,
                JWT_ISSUER)
        ];

        $this->response->getBody()->write(json_encode((object)$responseBody));
        return $this->response->withStatus(200);
    }
}
