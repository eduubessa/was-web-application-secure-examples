<?php

namespace App\Controllers\Api;

use ItsPossible\Core\Http\Controller;

class RegisterApiController extends Controller {

    public function request(string $username, string $password): void
    {
        $this->register($username, $password);
    }

    private function register(string $username, string $password): void
    {

    }

}