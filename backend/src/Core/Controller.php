<?php declare(strict_types=1);


namespace Source\Core;


use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Source\Models\UserDAO;


/**
 * Controller
 *
 * @property mixed $body
 *
 * @package Source\Core
 */
class Controller
{
    /** @var Response $response */
    protected Response $response;

    /** @var UserDAO */
    protected UserDAO $userDao;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->response = new Response;
    }

    /**
     * @param mixed $data
     * @param int $status
     *
     * @return Response|ResponseInterface
     */
    public function encodedWrite($data, int $status = 200): Response
    {
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withStatus($status);
    }
}
