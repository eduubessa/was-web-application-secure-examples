<?php

namespace App\Controllers\Api\Auth;

use ItsPossible\Core\Http\Controller;
use ItsPossible\Database\DB;

class LoginApiController extends Controller {

    public function request(string $username, string $password): void
    {
        $this->loginAttempt($username, $password);
    }

    private function loginAttempt(string $username, string $password): void
    {
        $db = new DB();
        $db->table('users')->select()
            ->where('username', $username)
            ->where('password', $password)
            ->where('is_activated', 1)
            ->get();
    }

}