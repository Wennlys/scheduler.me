<?php declare(strict_types=1);


namespace Source\App;


use Source\Models\File;
use Source\Core\Connection;
use Source\Models\FileDAO;
use Source\Models\UserDAO;
use Source\Models\User;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;

/**
 * Class FileController
 *
 * @package Source\App
 */
class FileController
{
    /** @var ResponseInterface*/
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    /**
     * FileController constructor.
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
    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $image = ($request->getUploadedFiles())["image"];

        $originalName = $image->getClientFilename();

        $imageExt = pathinfo($originalName, PATHINFO_EXTENSION);

        $name = bin2hex(openssl_random_pseudo_bytes(16)) . '.' . $imageExt;

        $image->moveTo('tmp/uploads/' . $name);
        
        $file = new File();
        $user = new User();

        $fileDao = new FileDAO($this->connection);
        $userDao = new UserDAO($this->connection);

        $file->setName($originalName);
        $file->setPath($name);

        $avatarId = $fileDao->save($file);

        $payload = getPayload($request);
        $userId = $payload['user_id'];

        $user->setAvatarId($avatarId);
        $user->setUserId($userId);

        $userDao->update($user);

        $this->response->getBody()->write('true');
        return $this->response->withStatus(200);
    }
}
