<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ranking;
use App\Models\Fish;
use Carbon\Carbon;

class RankingCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:create';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create rankings for each fish type';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // ランキングの開始日を設定
        $firstRankingDate = Carbon::create(2023, 3, 19)->startOfDay(); //初回のランキング実施日
        $intervalDays = 7;
        // Rankingのendカラムから最大値を取得(最も最新の日付)
        $lastRankingDate = Ranking::max('end'); //ランキング最終日が入る

        // 次のランキング開始日
        if ($lastRankingDate) { // ランキングがすでに作成されている場合
            
            $nextRankingDate = Carbon::parse($lastRankingDate)->addDays(1)->startOfDay(); //前回もランキングが実施されていれば最も遅い日付に+1日
    
            // ランキング作成時の時刻を含む週の日曜0時と土曜23:59:59を取得
            $start = $nextRankingDate;
            $end = $start->copy()->addDays($intervalDays)->endOfDay();

            // 集計対象となる魚種のIdを取得して配列に
            $fishIds = Fish::pluck('id')->toArray();
            
            //各魚種ごとに処理を始める
            foreach ($fishIds as $fishId) {
                //新しい期間の各魚種のランキングデータをランキングテーブルに挿入
                Ranking::create([
                    'start' => $start,
                    'end' => $end,
                    'num_of_participant' => 0,
                    'fish_id' => $fishId,
                    'rank' => null
                ]);
            }
        } else {
            $nextRankingDate = Carbon::create(2023, 3, 19)->startOfDay(); //前回のランキングがなければ3月19日をスタートにランキングを作成
            
            $start = $nextRankingDate; // ランキング作成時の時刻を含む週の日曜0時と土曜0時を取得
            $end = $start->copy()->addDays($intervalDays)->endOfDay();
            // 集計対象となる魚種のIdを取得して配列に
            $fishIds = Fish::pluck('id')->toArray();
            
            //各魚種ごとに処理を始める
            foreach ($fishIds as $fishId) {
                //新しい期間の各魚種のランキングデータをランキングテーブルに挿入
                Ranking::create([
                    'start' => $start,
                    'end' => $end,
                    'num_of_participant' => 0,
                    'fish_id' => $fishId,
                    'rank' => null
                ]);
            }
        }        
    }
}

// use App\Models\Post;
// use App\Models\Ranking;
// use App\Models\User;
// use App\Models\Fish;
// use Carbon\Carbon;

// // 初回のランキング作成日を設定
// $firstRankingDate = Carbon::create(2023, 3, 19)->startOfDay();

// // １週間おきに自動でランキングを作成するための設定
// $intervalDays = 7; // １週間
// $now = Carbon::now();
// $nextRankingDate = $firstRankingDate->copy()->addDays($intervalDays);
// if ($now->greaterThanOrEqualTo($nextRankingDate)) {
//     $fishIds = Fish::pluck('id');
//     foreach ($fishIds as $fishId) {
//         $start = $nextRankingDate->copy()->startOfDay();
//         $end = $nextRankingDate->copy()->addDays($intervalDays)->endOfDay();

//         $posts = Post::where('fish_id', $fishId)
//                      ->whereBetween('created_at', [$start, $end])
//                      ->orderByDesc('size')
//                      ->get();
//         $numOfParticipant = $posts->pluck('user_id')->unique()->count();

//         $rankings = [];
//         $rank = 1;
//         foreach ($posts as $post) {
//             $rankings[] = [
//                 'user_id' => $post->user_id,
//                 'post_id' => $post->id,
//                 'rank' => $rank,
//             ];
//             $rank++;
//         }

//         Ranking::create([
//             'start' => $start,
//             'end' => $end,
//             'num_of_participant' => $numOfParticipant,
//             'fish_id' => $fishId,
//             'ranking' => $rankings,
//         ]);
//     }
// }

// // ランキングに参加したユーザーが自分が何位だったかを知るためのコード例
// $userId = Auth::id(); // ログインユーザーのID
// $fishId = 1; // 対象の魚種ID
// $ranking = Ranking::where('fish_id', $fishId)
//                   ->where('start', '<=', $now)
//                   ->where('end', '>=', $now)
//                   ->first();
// if ($ranking) {
//     $rankings = $ranking->ranking;
//     $myRank = null;
//     foreach ($rankings as $r) {
//         if ($r['user_id'] === $userId) {
//             $myRank = $r['rank'];
//             break;
//         }
//     }
//     if ($myRank) {
//         echo 'あなたは' . $myRank . '位でした';
//     } else {
//         echo 'あなたはランキングに参加していません';
//     }
// }

