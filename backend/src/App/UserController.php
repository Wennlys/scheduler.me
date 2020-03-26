<?php declare(strict_types=1);


namespace Source\App;


use Source\Models\User;
use Source\Models\UserDAO;
use Source\Core\Connection;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Exception;


/**
 * Class UserController
 *
 * @package Source\App
 */
class UserController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection*/
    private Connection $connection;

    /**
     * UserController constructor.
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
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);

        return $this->encodedWrite($userDao->findAll());
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);

        $login = json_decode((string)$request->getBody())->login;
        $result = $userDao->findByLogin($login);
        return $this->encodedWrite($result);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $reqBody = json_decode((string)$request->getBody(), true);

        $user = new User();
        $userDao = new UserDAO($this->connection);

        $user->setUserName($reqBody['user_name']);
        $user->setFirstName($reqBody['first_name']);
        $user->setLastName($reqBody['last_name']);
        $user->setEmail($reqBody['email']);
        $user->setPassword($reqBody['password']);
        $user->setProvider($reqBody['provider']);

        $userDao->save($user);

        return $this->encodedWrite(true);
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

        $payload = getPayload($request);
        $user->setUserId($payload['user_id']);

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


        $userDao->update($user);

        return $this->encodedWrite(true);
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

        return $this->encodedWrite(true);
    }

    /**
     * @param     $data
     * @param int $status
     *
     * @return ResponseInterface
     */
    public function encodedWrite($data, int $status = 200): ResponseInterface
    {
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withStatus($status);
    }
}
