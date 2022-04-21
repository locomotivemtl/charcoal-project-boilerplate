<?php

/** The application's absolute root path */
$this['base_path'] = dirname(__DIR__).'/';

/** Import core settings */
$this->addFile(__DIR__ . '/common/config.json');

/** Import templates */
$this->addFile(__DIR__ . '/common/templates.json');

/** Import attachments */
$this->addFile(__DIR__ . '/common/attachments.json');

/** Import local settings */
$appEnv = 'local';
if (file_exists(__DIR__ . '/common/config.'.$appEnv.'.json')) {
    $this->addFile(__DIR__ . '/common/config.'.$appEnv.'.json');
}

$this['adminPath'] ??= 'admin';
$isAdmin = $_SERVER['REQUEST_URI'] == '/'.$this['adminPath'] || strstr($_SERVER['REQUEST_URI'], '/'.$this['adminPath'].'/') !== false;
if (!$isAdmin) {
    /** Import app-only settings */
    $this->addFile(__DIR__ . '/app.php');
} else {
    // admin.php is loaded automatically by the charcoal-admin module.
}
