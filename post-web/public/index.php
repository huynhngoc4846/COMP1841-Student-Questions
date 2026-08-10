<?php

define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_FOLDER', 'http://localhost/post-web/public');
define('BASE_URL', 'http://localhost/post-web');

if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
} else {
    die('Hệ thống thiếu vendor/autoload.php. Hãy chạy lệnh "composer install".');
}

ini_set('display_errors', getenv('APP_DEBUG') === '1' ? '1' : '0');
ini_set('display_startup_errors', getenv('APP_DEBUG') === '1' ? '1' : '0');
error_reporting(E_ALL);

use App\Core\App;

$app = new App();
