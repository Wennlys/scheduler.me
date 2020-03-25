<?php declare(strict_types=1);


namespace Source\App;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Source\Models\File;
use Source\Models\FileDAO;
use Source\Core\Connection;

class FileController
{
    /** @var ResponseInterface*/
    private ResponseInterface $response;

    /** @var Connection */
    private Connection $connection;

    public function __construct(Connection $connection, ResponseInterface $response)
    {
        $this->connection = $connection;
        $this->response = $response;
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $image = $request->getUploadedFiles()["image"];

        $originalName = $image->getClientFilename();

        $imageExt = pathinfo($originalName, PATHINFO_EXTENSION);

        $name = bin2hex(openssl_random_pseudo_bytes(16)) . '.' . $imageExt;

        $image->moveTo('tmp/uploads/' . $name);
        
        $file = new File();

        $file->setName($originalName);
        $file->setPath($name);

        $fileDao = new FileDAO($this->connection);

        $fileDao->save($file);

        $this->response->getBody()->write('true');
        return $this->response->withStatus(200);
    }
}
