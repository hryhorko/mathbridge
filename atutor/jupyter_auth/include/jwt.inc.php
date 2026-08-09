<?php

if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

class JupyterAuthJWT
{
    private static function base64Url($data)
    {
        return rtrim(
            strtr(base64_encode($data), '+/', '-_'),
            '='
        );
    }

    public static function generate($username)
    {
        $now = time();

        $header = self::base64Url(
            json_encode(
                array(
                    'typ' => 'JWT',
                    'alg' => 'HS256'
                )
            )
        );

        $payload = self::base64Url(
            json_encode(
                array(
                    'username' => $username,
                    'iat'      => $now,
                    'nbf'      => $now,
                    'exp'      => $now + JupyterAuthConfig::TOKEN_LIFETIME
                )
            )
        );

        $signature = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            JupyterAuthConfig::getSecret(),
            true
        );

        $signature = self::base64Url($signature);

        return $header . '.' . $payload . '.' . $signature;
    }
}