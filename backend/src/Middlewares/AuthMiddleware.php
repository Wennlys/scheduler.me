<?php declare(strict_types=1);


namespace Source\Middlewares;


use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use ReallySimpleJWT\Token;


/**
 * Class AuthMiddleware
 *
 * @package Source\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
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
        if (Token::validate(getToken($request), JWT_SECRET)) {
            return $handler->handle($request);
        }

        $this->response->getBody()->write(json_encode("Not valid token."));
        return $this->response->withStatus(400);
    }
}
