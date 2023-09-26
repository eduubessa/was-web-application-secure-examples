<?php

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once(__DIR__ . '/../vendor/autoload.php');
}

use App\Controllers\Api\Auth\LoginApiController;

$loginApiController = new LoginApiController();
$loginApiController->request("eduubessa", "password123");