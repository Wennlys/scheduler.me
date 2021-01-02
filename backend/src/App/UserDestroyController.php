<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;
use Source\Core\Connection;
use Source\Models\User;
use Source\Models\UserDAO;

class UserDestroyController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function destroy(ServerRequestInterface $request): ResponseInterface
    {
        ['password' => $currentPassword] = json_decode((string)$request->getBody(), true);

        $user = new User();
        $userDao = new UserDAO($this->connection);

        ['user_id' => $userId] = getPayload($request);

        $user->setUserId($userId);
        $user->setCurrentPassword($currentPassword);

        $userDao->delete($user);

        $this->response->getBody()->write(json_encode(true));
        return $this->response->withStatus(200);
    }
}
