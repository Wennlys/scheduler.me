<?php declare(strict_types=1);



namespace Source\App;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;
use Source\Core\Connection;
use Source\Models\User;
use Source\Models\UserDAO;

/**
 * Class UserDestroyController
 *
 * @package Source\App
 */
class UserDestroyController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserDestroyController constructor.
     *
     * @param Connection        $connection
     * @param ResponseInterface $response
     */
    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function destroy(ServerRequestInterface $request): ResponseInterface
    {
        $currentPassword = (json_decode((string)$request->getBody()))->password;

        $user = new User();
        $userDao = new UserDAO($this->connection);

        $payload = getPayload($request);

        $user->setUserId($payload['user_id']);
        $user->setCurrentPassword($currentPassword);

        $userDao->delete($user);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
