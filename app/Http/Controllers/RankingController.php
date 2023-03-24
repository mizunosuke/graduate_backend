<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRankingRequest;
use App\Http\Requests\UpdateRankingRequest;
use App\Models\Ranking;
use App\Models\Post;
use App\Models\User;
use App\Models\Fish;
use Carbon\Carbon;

class RankingController extends Controller
{
    //
    public function index()
    {
        //
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();
        //期間内のランキングデータ一覧を取得
        $allranking = Ranking::wherebetween("created_at",[$start, $end])->get();
        // ランキングデータに魚の名前を追加
        foreach ($allranking as $ranking) {
            $fish = Fish::find($ranking->fish_id);
            $ranking->fish_name = $fish->name;
        }

        //ランキングデータに投稿データを3件追加
        foreach ($allranking as $ranking) {
            $posts = Post::where("fish_id", "=", $ranking->fish_id)->orderby("size", "desc")->take(3)->get();
            $ranking->posts = $posts;
        }

        return $allranking;
    }

    public function show (Request $request, int $id)
    {
        //fish_idを元にランキングのデータを取得する
        $rankingData = Ranking::where("fish_id", "=", $id)->first(); // 最初のレコードを取得する
        if (!$rankingData) {
            // $rankingDataがnullの場合、404エラーを返す
            abort(404);
        }

        // ランキング実施期間内の開始日時と終了日時を取得する
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        // 投稿データを取得し、ソートする
        $postData = Post::where("fish_id", "=", $id)->whereBetween("day_of_fishing", [$start, $end])->orderBy("size", "desc")->get();

        $userPostData = []; // ユーザーの投稿データを格納する配列
        foreach ($postData as $post) {
            // 投稿に紐づくユーザーデータを取得する
            $user = User::where("id", "=", $post->user_id)->first();

            // ユーザーの投稿データを連想配列にまとめる
            $userPost = [
                "post_id" => $post->id,
                "user_id" => $user->id,
                "user_name" => $user->name,
                "attachment" => $post->attachment,
                "size" => $post->size,
                "day_of_fishing" => $post->day_of_fishing,
                "created_at" => $post->created_at,
                // その他必要なデータがあればここに追加する
            ];

            // ユーザーの投稿データを配列に追加する
            array_push($userPostData, $userPost);
        }
        return $userPostData;
    }

    
}

