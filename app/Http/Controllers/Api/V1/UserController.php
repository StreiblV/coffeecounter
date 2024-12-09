<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function findAll() {
        $users = User::all();
        return response()->json($users);
    }

    public function token() {
        $token = auth()->user()->createToken("api", expiresAt: now()->addHours(4));

        return response()->json(data: $token);
    }

    public function create() {
        $user_name = request()->json("name");
        $user_password = request()->json("password");
        $user_email = request()->json("email");

        if (!($user_name && $user_password && $user_email)) {
            return response()->setStatusCode(400)->json(array(
                "error" => array(
                    "message" => "invalid request. name and password are requried fields for a new user",
                )
            ));
        }

        $user = User::create([
            "name" => $user_name,
            "email" => $user_email,
            "password" => $user_password
        ]);

        return response()->json($user);
    }
}
