<?php

if (!defined('AT_INCLUDE_PATH')) {
    exit;
}

/*
 * This file must be included by the ATutor Module object.
 */
if (!isset($this) || strtolower(get_class($this)) != 'module') {
    exit(__FILE__ . ' is not a Module');
}

/*
 * Register instructor privilege.
 */
define('AT_PRIV_JUPYTER', $this->getPrivilege());

/*
 * Register module page.
 */
$this->_module_pages['mods/jupyter_auth/index.php'] = array(
    'title_var' => 'jupyter_auth',
    'parent'    => 'tools/index.php'
);

/*
 * Register the tool on the course home page.
 */
$this->_tool_pages['mods/jupyter_auth/index.php'] = array(
    'title_var' => 'jupyter_auth'
);