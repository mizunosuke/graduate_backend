<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        //入力内容のバリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'google_id' => 'required|unique:users',
            'icon_path' => 'nullable'
        ]);
    
        //ユーザーの作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $validatedData['google_id'],
            'icon_path' => $request->icon_path,
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Registration successful'
        ], 201);
    }
}
