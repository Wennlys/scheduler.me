<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;
use Exception;
use Source\Core\Connection;
use Source\Models\User;
use Source\Models\UserDAO;


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
        $reqBody = json_decode((string)$request->getBody(), true);

        $login = $reqBody['login'];
        $password = $reqBody['password'];

        $userDao = new UserDAO($this->connection);
        $user = new User();

        if (is_email($login)) {
            $user->setEmail($login);
        } else {
            $user->setUserName($login);
        }

        $row = $userDao->findByLogin($user);

        if (!$row) {
            $this->response->getBody()->write(json_encode("User not found."));
            return $this->response->withStatus(200);
        }

        if (!password_verify($password, $row->password)) {
            $this->response->getBody()->write(json_encode("Wrong password."));
            return $this->response->withStatus(401);
        }

        $responseBody = [
            "user" => [
                "id" => $row->id,
                "name" => $row->user_name,
                "email" => $row->email,
            ],
            "token" => Token::create(
                $row->id,
                JWT_SECRET,
                JWT_EXPIRATION,
                JWT_ISSUER)
            ];

        $this->response->getBody()->write(json_encode((object)$responseBody));
        return $this->response->withStatus(200);
    }
}
