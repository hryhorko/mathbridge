<?php

define('AT_INCLUDE_PATH', '../../include/');
require_once AT_INCLUDE_PATH . 'vitals.inc.php';

require_once __DIR__ . '/include/config.inc.php';
require_once __DIR__ . '/include/jwt.inc.php';
require_once __DIR__ . '/include/redirect.inc.php';

/*
 * Only authenticated ATutor users may launch JupyterHub.
 */
if (!isset($_SESSION['member_id'])) {
    header('Location: ' . AT_BASE_HREF . 'login.php');
    exit;
}

$username = $_SESSION['login'];

$token = JupyterAuthJWT::generate($username);

$url = JupyterAuthRedirect::build($token);

header('Location: ' . $url);
exit;