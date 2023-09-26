<?php

namespace App\Controllers\Api\Auth;

use ItsPossible\Core\Http\Controller;
use ItsPossible\Database\DB;

class RegisterApiController extends Controller {

    public function request(string $username, string $password): void
    {
        $this->register($username, $password);
    }

    private function register(string $username, string $password): void
    {
        $db = new DB();
        $db->table('users')->insert([
            'username' => $username,
            'password' => password_hash('password', PASSWORD_ARGON2ID)
        ]);
    }

}