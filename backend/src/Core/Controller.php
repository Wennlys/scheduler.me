<?php


namespace Source\Core;


use Source\Models\User;
use Laminas\Diactoros\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Controller
 *
 * @property mixed $body
 *
 * @package Source\Core
 */
abstract class Controller
{
    /** @var User $user */
    protected User $user;

    /** @var Response $response */
    protected Response $response;

    /** @var PDO|null */
    protected ?PDO $instance;

    public function __construct()
    {
        $this->user = new User();
        $this->response = new Response();
        $this->instance = Connection::getInstance();
    }

    public function getRows(?string $terms = null, ?string $params = null,
        string $columns = '*')
    {
        return ($this->user)->find($terms, $params, $columns)->fetch(true);
    }

    public function getToken(ServerRequestInterface $request)
    {
        $header = $request->getHeaders()["authorization"][0];
        if (!$header) {
            return $this->encodedWrite("Token not provided", 401);
        }
         $token = explode(' ', $header);
         return $token[1];
    }

    public function encodedWrite($data, int $status = 200)
    {
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withStatus($status);
    }
}
