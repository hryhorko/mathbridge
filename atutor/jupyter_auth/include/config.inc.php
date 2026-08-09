<?php

if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

class JupyterAuthConfig
{
    const HUB_URL = 'http://Enter a valid address';

    const TOKEN_LIFETIME = 300;

    public static function getSecret()
    {
        $secret = getenv('JUPYTERHUB_JWT_SECRET');

        if ($secret !== false && $secret !== '') {
            return $secret;
        }

        return 'Edit me';
    }
}