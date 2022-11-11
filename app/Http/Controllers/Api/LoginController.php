<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->status != 'writer' && $user->status != 'admin') {
                return response()->json([
                    'msg' => 'cannot login'
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'data' => 'email or password incorrect',
                    'error' => []
                ], 500);
            }

            $token = $user->createToken($user->name);

            $user['token'] =  $token->plainTextToken;

            $user = LoginUserResource::make($user);



            return response()->json([
                'data' => $user,
                'error' => [],
            ], 200);
        }
    }


    public function logout(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::where('id', $request->id)->first();

        if (!$user) {

            return response()->json([
                'msg' => 'user not exists'
            ]);
        }
        $user->tokens()->delete();

        return response()->json([
            'msg' => 'logout successfuly'
        ]);
    }
}
