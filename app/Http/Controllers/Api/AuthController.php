<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(["email", "password"]))) {
            return $this->error("Invalid credentials", 401);
        }

        $user = User::FirstWhere("email", $request->email);

        $token = $user->createToken(
            "API TOKEN for " . $user->name,
            ["*"],
            now()->addMonth()
        )->plainTextToken;

        return $this->ok("Authenticated.", ["token" => $token], 200);
    }

    public function register()
    {
        return $this->ok("Hello API", 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok("Logged out");
    }
}
