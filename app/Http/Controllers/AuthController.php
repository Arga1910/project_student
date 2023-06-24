<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'gender' => ['required', Rule::in(['L', 'P'])],
            'umur' => 'required|integer',
            'email' => 'required|string|email|unique:users',
            'alamat' => 'required|string|max:255|',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'gender' => $request->gender,
            'umur' => $request->umur,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('auth_token');

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);

        return redirect()->route('profile');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Your account has not been registered, please register first',
            ], 401);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $level = $user->level;

            if ($level === 'admin') {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'level' => 'admin',
                    'id' => $user->id,

                ]);
            } elseif ($level === 'user') {
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'level' => 'user',
                    'id' => $user->id,
                ]);
            }
        } else {
            return response()->json(["message" => "Invalid email or password"]);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user->tokens()->count() > 0) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout berhasil'], 200);
        } else {
            return response()->json(['message' => 'Anda belum login'], 401);
        }

        //     $request->user()->token->revoke();
        //     return response()->json(["status" => "anda sudah logout"], 200);
    }

    public function admin()
    {
        $user = User::all();
        return response()->json(['user' => $user]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'user' => $user,
                'profile' => $user->profile,
            ]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
