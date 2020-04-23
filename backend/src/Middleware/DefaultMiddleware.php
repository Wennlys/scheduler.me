<?php declare(strict_types=1);


namespace Source\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DefaultMiddleware
 *
 * @package Source\Middleware
 */
class DefaultMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * AuthMiddleware constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
         $response = $handler->handle($request);
         return $response->withHeader('Access-Control-Allow-Origin', '*')
                      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

    }
}
