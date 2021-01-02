<?php 
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use ReallySimpleJWT\Token;

function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_password(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= MIN_PASS_LEN && mb_strlen
            ($password) <= MAX_PASS_LEN)) {
        return true;
    }
    return false;
}

function getPayload(ServerRequestInterface $request): ?array
{
    [$header] = $request->getHeaders()["authorization"];
    if (!$header) {
        return null;
    }

    [, $token] = explode(' ', $header);

    return Token::getPayload($token, JWT_SECRET);
}

