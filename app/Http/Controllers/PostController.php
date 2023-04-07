<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Fish;
use App\Models\User;
use App\Models\Ranking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PostController extends Controller
{
    //
    public function index (Request $request, int $id) 
    {

    }

    public function store (Request $request)
    {
        $validatedData = $request->validate([
        'attachment' => 'required|string',
        'kind' => 'required|string',
        'size' => 'required|numeric',
        'day_of_fishing' => 'required',
        'user_id' => 'required|integer'
        ]);

        // 魚種テーブルから魚種IDを取得
        $fish = Fish::where('name', $validatedData['kind'])->first();
        if(!$fish){
            // 魚種が存在しない場合は新規作成する
            $fish = new Fish();
            $fish->name = $validatedData['kind'];
            $fish->save();
        }

        // // 日付をCarbonオブジェクトに変換
        // $date = Carbon::createFromFormat('Y-m-d', $validatedData['day_of_fishing']);
        

        // ポストモデルに保存するデータを準備
        $post = new Post();
        $post->user_id = $validatedData['user_id'];
        $post->attachment = $validatedData['attachment'];
        $post->fish_id = $fish->id;
        $post->size = $validatedData['size'];
        $post->day_of_fishing = $validatedData['day_of_fishing'];
        $post->save();

        $ranking = Ranking::where('fish_id', $post->fish_id)->first();
        if ($ranking) {
            $ranking->increment('num_of_participant');
        }

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    public function user ($id)
    {
        //user_idと紐づくpostを取得(postテーブルのrankingがnullでないものに限る)
        $posts = Post::where("user_id", "=", $id)->get();

        //投稿データ内のfish_idから名前を取得
        foreach ($posts as $post) {
            $fish = Fish::where('id', $post->fish_id)->first(); // fish_idに対応する魚種を取得
            $post->fishname = $fish->name; // $postオブジェクトに魚種名を追加
        }

        return ["postdata" => $posts];
    }
}
