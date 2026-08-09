<?php

if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

class JupyterAuthRedirect
{
    public static function build($token)
    {
        return JupyterAuthConfig::HUB_URL .
               '/hub/login?token=' .
               urlencode($token);
    }
}