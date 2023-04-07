<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

//全ランキングデータ取得
Route::get("/rankings", [ RankingController::class, "index"]);

Route::get("/rankings/{id}", [ RankingController::class, "show"]);

//魚種データから投稿取得
Route::get("/fish/posts", [ FishController::class, "index"]);

Route::get("/fish/{id}", [FishController::class, "fish"]);

//user_idから投稿取得
Route::get("/posts/user/{id}", [PostController::class, "user"]);

//user情報の取得
Route::put("/user/{id}", [ UserController::class, "update"]);
Route::get("/user/{id}", [ UserController::class, "index"]);


//新規登録
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);


//投稿データの保存
Route::post('/posts', [ PostController::class, "store"]);



