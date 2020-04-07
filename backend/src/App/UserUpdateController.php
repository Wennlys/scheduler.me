<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;
use Source\Models\User;
use Exception;

/**
 * Class UserUpdateController
 *
 * @package Source\App
 */
class UserUpdateController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserUpdateController constructor.
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
    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $reqBody = json_decode((string)$request->getBody(), true);

        $user = new User;
        $userDao = new UserDAO($this->connection);

        ['user_id' => $userId] = getPayload($request);
        $user->setUserId($userId);

        if(!empty($reqBody['current_password']))
            $user->setCurrentPassword($reqBody['current_password']);
        if (!empty($reqBody['user_name']))
            $user->setUserName($reqBody['user_name']);
        if (!empty($reqBodyfirst_name))
            $user->setFirstName($reqBody['first_name']);
        if (!empty($reqBody['last_name']))
            $user->setLastName($reqBody['last_name']);
        if (!empty($reqBody['email']))
            $user->setEmail($reqBody['email']);
        if (!empty($reqBody['password']))
            $user->setPassword($reqBody['password']);
        if (!empty($reqBody['avatar_id']))
            $user->setAvatarId($reqBody['avatar_id']);

        $updated = $userDao->update($user);

        $this->response->getBody()->write(json_encode((object)[
            "id" => $updated['id'],
            "user_name" => $updated['user_name'],
            "full_name" => $updated['first_name'] . " " .$updated['last_name'],
            "email" => $updated['email'],
            "provider" => $updated['provider'] === "1" ? true : false,
        ]));
        return $this->response->withStatus(200);
    }
}
