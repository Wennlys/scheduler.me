<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;
use Source\Models\UserDAO;
use Source\Core\Connection;

/**
 * Class SessionController
 *
 * @package Source\App
 */
class SessionController
{
    /** @var Connection */
    private Connection $connection;

    /** @var ResponseInterface */
    private ResponseInterface $response;

    /**
     * SessionController constructor.
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
     */
    public function store(ServerRequestInterface $request): Response
    {
        $body = json_decode((string)$request->getBody(), true);

            $login = $body['login'];
            $password = $body['password'];

        $userDao = new UserDAO($this->connection);
        $user = $userDao->findByLogin($login);


        if (!$user)
            return $this->encodedWrite("Usuário não encontrado", 401);

        if (!password_verify($password, $user->password))
            return $this->encodedWrite("Wrong password", 401);

        return $this->encodedWrite((object)[
            "user" => [
                "id" => $user->id,
                "name" => $user->user_name,
                "email" => $user->email ],
            "token" => Token::create($user->id, JWT_SECRET, JWT_EXPIRATION, JWT_ISSUER)
        ]);
    }

    /**
     * @param     $data
     * @param int $status
     *
     * @return ResponseInterface
     */
    public function encodedWrite($data, int $status = 200)
    {
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withStatus($status);
    }

}
