<?php


if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

if (!$msg->containsErrors() && file_exists(dirname(__FILE__) . '/module.sql')) {

    require_once AT_INCLUDE_PATH . 'classes/sqlutility.class.php';

    $sqlUtility = new SqlUtility();

    $sqlUtility->revertQueryFromFile(
        dirname(__FILE__) . '/module.sql',
        TABLE_PREFIX
    );
}

?>
