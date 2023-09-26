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
        $users = $db->table('users')->select()
                    ->where('username', $username)
                    ->get();

        foreach($users as $user)
        {
            if(password_verify($password, $user->password)) {
                echo "Logged";
            }else{
                echo "Not logged";
            }
        }
    }

}