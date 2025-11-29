<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function create_jwt($data, $expireMinutes = 60)
{
    $issuedAt   = time();
    $expire     = $issuedAt + (60 * $expireMinutes); // default 1 jam
    $payload = array_merge($data, [
        'iat' => $issuedAt,
        'exp' => $expire
    ]);

    $key = getenv('JWT_SECRET') ?: 'supersecretkey'; // taruh di .env
    return JWT::encode($payload, $key, 'HS256');
}

function verify_jwt($token)
{
    try {
        $key = getenv('JWT_SECRET') ?: 'supersecretkey';
        return JWT::decode($token, new Key($key, 'HS256'));
    } catch (\Exception $e) {
        return null;
    }
}
