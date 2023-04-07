<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // ユーザーモデルの取得

        // リクエストデータを取得
        $icon_path = $request->input('icon_path');
        $name = $request->input('name');
        $email = $request->input('email');

        // ユーザーモデルのプロパティを更新
        $user->icon_path = $icon_path;
        $user->name = $name;
        $user->email = $email;

        $user->save(); // データベースの保存

        return response()->json(['user' => $user]); 
    } 
    
    public function index(Request $request, $id)
    {
        $user = User::find($id); // ユーザーモデルの取得
        return $user; 
    } 

}
