<?php
declare(strict_types=1);
use Core\App;
use Core\Database;
require_once __DIR__ . '/vendor/autoload.php';

file_exists(__DIR__ . '/vendor/autoload.php');
file_exists(__DIR__ . '/config.php');
file_exists(__DIR__ . '/core/App.php');

$config = require_once __DIR__ . '/config.php';

try {
    App::bind('config', $config);
    App::bind('database', new Database($config['database']));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
;
