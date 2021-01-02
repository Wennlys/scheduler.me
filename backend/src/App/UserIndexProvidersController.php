<?php 
declare(strict_types=1);

namespace Source\App;

use Psr\Http\Message\ResponseInterface;
use Source\Core\Connection;
use Source\Models\UserDAO;

class UserIndexProvidersController
{
    private ResponseInterface $response;
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function index(): ResponseInterface
    {
        $userDao = new UserDAO($this->connection);
        $providers = array_map(function ($provider) {
            return [
                "id" => $provider->id,
                "first_name" => $provider->first_name,
                "last_name" => $provider->last_name,
                "email" => $provider->email,
                "avatar" => [
                    "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/{$provider->path}",
                    "name" => $provider->name,
                    "path" => $provider->path,
                ],
            ];
        }, $userDao->findAllProviders());

        $this->response->getBody()->write(json_encode($providers, JSON_UNESCAPED_SLASHES));
        return $this->response->withStatus(200);
    }
}
