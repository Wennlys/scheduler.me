<?php


namespace Source\Middleware;


use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Source\Core\Controller;
use ReallySimpleJWT\Token;


class AuthMiddleware extends Controller implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $token = $this->getToken($request);

        if (Token::validate($token, JWT_SECRET)) {
            return $handler->handle($request);
        }

        return $this->encodedWrite("Invalid token", 400);
    }
}
