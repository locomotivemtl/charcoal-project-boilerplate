<?php
// Custom configuration for the admin backend. Automatically loaded from charcoal-admin module.

/** Import elFinder settings */
$this->addFile(__DIR__ . '/admin/elfinder.json');

/** Admin settings */
$this->addFile(__DIR__ . '/admin/admin.json');

/** Admin-only middlewares */
$this->addFile(__DIR__ . '/admin/middlewares.json');

/** Admin-only HTTP headers */
$this->addFile(__DIR__ . '/admin/headers.php');


/** Import `charcoal-attachment` routes */
$this->addFile(dirname(__DIR__) . '/vendor/locomotivemtl/charcoal-attachment/config/admin.json');

