<?php
// Custom configuration for the frontend app.

/** Import routes */
$this->addFile(__DIR__ . '/app/routes.json');

/** Import redirections */
$this->addFile(__DIR__ . '/app/redirections.json');

/** App-only middlewares */
$this->addFile(__DIR__ . '/app/middlewares.json');

/** App-only HTTP headers */
$this->addFile(__DIR__ . '/app/headers.php');
