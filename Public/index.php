<?php

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once(__DIR__ . '/../vendor/autoload.php');
}

use App\Controllers\Api\Auth\LoginApiController;
use App\Controllers\Api\Auth\RegisterApiController;

$loginApiController = new LoginApiController();
$loginApiController->request("eduardo.bessa", "password");

//$registerApiController = new RegisterApiController();
//$registerApiController->request('eduardo.bessa', 'password');