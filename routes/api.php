<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\UserController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

/*
|------------------------------------------------s--------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//全ランキングデータ取得
Route::get("/rankings", [ RankingController::class, "index"]);

Route::get("/rankings/{id}", [ RankingController::class, "show"]);

//魚種データから投稿取得
Route::get("/fish/posts", [ FishController::class, "index"]);

//user情報の取得
Route::get("/user", [ UserController::class, "index"]);

//トークンの生成
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

//ログイン認証
Route::post('/sanctum/token', function (Request $request) {
    //入力内容のバリデーション
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    //emailが一致するユーザーを取得
    $user = User::where('email', $request->email)->first();

    //もしuserが取得できないorパスワードがとってきたユーザーと一致しない場合
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    //とってきたユーザーに対してAPIトークンを発行
    return $user->createToken($request->device_name)->plainTextToken;
});

//新規登録
Route::group(['middleware' => ['api']], function () {
    Route::get('/auth/google', [UserController::class, 'google']);
  });
