<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;

/**
 * Class UserIndexProvidersController
 *
 * @package Source\App
 */
class UserIndexProvidersController
{
    /** @var ResponseInterface */
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    /**
     * UserIndexProvidersController constructor.
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

        $providers = $userDao->findAllProviders();

        $responseBody = [];
        foreach ($providers as $provider) {
            $responseBody[] = [
                "id" => $provider->id,
                "full_name" => $provider->first_name . " " . $provider->last_name,
                "email" => $provider->email,
                "avatar" => [
                    "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/{$provider->path}",
                    "name" => $provider->name,
                    "path" => $provider->path,
                ],
            ];
        }

        $this->response->getBody()->write(json_encode($responseBody, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
