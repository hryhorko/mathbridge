<?php

if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

if (file_exists(dirname(__FILE__) . '/module.sql')) {

    require_once AT_INCLUDE_PATH . 'classes/sqlutility.class.php';

    $sqlUtility = new SqlUtility();

    $sqlUtility->queryFromFile(
        dirname(__FILE__) . '/module.sql',
        TABLE_PREFIX
    );
}