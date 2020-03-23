<?php declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param string $password
 * @return bool
 */
function is_password(string $password): bool
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= MIN_PASS_LEN && mb_strlen
            ($password) <= MAX_PASS_LEN)) {
        return true;
    }
    return false;
}

function getToken(ServerRequestInterface $request): ?string
{
    $header = $request->getHeaders()["authorization"][0];
    if ($header) {
        $token = explode(' ', $header);
        return $token[1];
    }
    return null;
}

