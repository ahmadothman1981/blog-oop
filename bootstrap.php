<?php
declare(strict_types=1);
use Core\App;
use Core\Database;
use Core\ErrorHandler;
require_once __DIR__ . '/vendor/autoload.php';

file_exists(__DIR__ . '/vendor/autoload.php');
file_exists(__DIR__ . '/config.php');
file_exists(__DIR__ . '/core/App.php');

set_exception_handler([ErrorHandler::class, 'handleException']);
set_error_handler([ErrorHandler::class, 'handleError']);

$config = require_once __DIR__ . '/config.php';

try {
    App::bind('config', $config);
    App::bind('database', new Database($config['database']));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
;
