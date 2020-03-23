<?php declare(strict_types=1);


namespace Source\App;


use Source\Core\Controller;
use Source\Models\User;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use ReallySimpleJWT\Token;
use Exception;


/**
 * Class UserController
 *
 * @package Source\App
 */
class UserController extends Controller
{
    public function __construct($var = null)
    {
        parent::__construct();

        $this->var = $var;

    }
    /**
     * @return Response|ResponseInterface
     */
    public function index(): Response
    {
//        return $this->encodedWrite($this->userDao->findAll());
        return $this->encodedWrite($this->var);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array|mixed|null
     */
    public function show(ServerRequestInterface $request): Response
    {
        $login = json_decode($request->getBody())->login;
        $result = $this->userDao->findByLogin($login);
        return $this->encodedWrite($result);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     * @throws Exception
     */
    public function store(ServerRequestInterface $request): Response
    {
        $reqBody = json_decode($request->getBody(), true);

        $user = new User();

        try {
            $user->setUserName($reqBody['user_name']);
            $user->setFirstName($reqBody['first_name']);
            $user->setLastName($reqBody['last_name']);
            $user->setEmail($reqBody['email']);
            $user->setPassword($reqBody['password']);
            $user->setProvider($reqBody['provider']);

            $this->userDao->save($user);
        } catch (Exception $e) {
            return $this->encodedWrite($e->getMessage(), 400);
        }

        return $this->encodedWrite(true);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response|ResponseInterface
     * @throws Exception
     */

    public function update(ServerRequestInterface $request): Response
    {
        $reqBody = json_decode($request->getBody(), true);

        if(!empty($reqBody['current_password']))
            $currentPass = $reqBody['current_password'];

        $user = new User;

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

        $payload = Token::getPayload(getToken($request), JWT_SECRET);
        $id = $payload['user_id'];

        try {
            $this->userDao->update($user, $currentPass, $id);
        } catch (Exception $e) {
            return $this->encodedWrite($e->getMessage(), 400);
        }

        return $this->encodedWrite(true);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(ServerRequestInterface $request): Response
    {
        $password = (json_decode($request->getBody()))->password;

        $payload = Token::getPayload(getToken($request), JWT_SECRET);
        $id = $payload['user_id'];

        try {
            $this->userDao->delete($id, $password);
        } catch (Exception $e) {
            return $this->encodedWrite($e->getMessage(), 400);
        }

        return $this->encodedWrite(true);
    }

}
