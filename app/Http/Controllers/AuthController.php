<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());
        }
        $user = User::create($validator->validated());

        return response()->json([
            'data' => $user,
            'message' => 'Successfully registered',
            'status' => Response::HTTP_OK
        ], 201);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (Auth::attempt($validator->validated())) {
            $token = $request->user()->createToken('posToken')->plainTextToken;
        } else {
            return response()->json([
                'message' => 'Login Fails',
                'status' => Response::HTTP_UNAUTHORIZED,
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'message' => 'Successfully login',
            'status' => Response::HTTP_OK
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logout',
            'status' => Response::HTTP_OK
        ]);
    }
}
