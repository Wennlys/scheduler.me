<?php declare(strict_types=1);


namespace Source\App;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;
use Source\Models\File;
use Source\Core\Connection;
use Source\Models\FileDAO;
use Source\Models\UserDAO;
use Source\Models\User;

/**
 * Class FileStoreController
 *
 * @package Source\App
 */
class FileStoreController
{
    /** @var ResponseInterface*/
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    /**
     * FileStoreController constructor.
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

        $size = $image->getSize();

        if ($size > 50000) {
            $this->response->getBody()->write(json_encode([
               "avatar_id" => 1,
               "created_at" => "2020-04-02 16:46:38",
               "updated_at" => "2020-04-07 20:42:06",
               "name" => "default-avatar.jpg",
               "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/default-avatar.jpg",
               "path" => "default-avatar.jpg"
           ]));
           return $this->response->withStatus(200);
        }

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

        ['user_id' => $userId] = getPayload($request);

        $user->setAvatarId($avatarId);
        $user->setUserId($userId);

        [
            "avatar_id" => $avatarId,
            "created_at" => $createdAt,
            "updated_at" => $updatedAt,
            "name" => $name,
            "path" => $path
        ] = $userDao->update($user);

        $this->response->getBody()->write(json_encode([
            "avatar_id" => $avatarId,
            "created_at" => $createdAt,
            "updated_at" => $updatedAt,
            "name" => $name,
            "url" => "http://{$_SERVER['HTTP_HOST']}/tmp/uploads/{$path}",
            "path" => $path
        ]));
        return $this->response->withStatus(200);
    }
}
