<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Ranking;

class RankingCalculateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate weekly ranking for each fish species';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 現在日時を基準にした週の初めの日時を取得
        $weekStart = Carbon::now()->startOfWeek()->startOfDay();
        // 現在日時を基準にした週の終わりの日時を取得
        $weekEnd = Carbon::now()->endOfWeek()->endOfDay();
        // 1週間前から現在までの投稿を取得(魚種関係なくすべて)
        $posts = Post::whereBetween('day_of_fishing', [$weekStart, $weekEnd])->get();

        // fish_idで取得したすべての投稿をグループ分け
        $fishSpecies = $posts->groupBy('fish_id');
        
        //fish_idごとの投稿を１個ずつ取り出してランキングをつけていく(fish_id=2のラベルがついた投稿50件に1個ずつ処理してく感じ)
        foreach ($fishSpecies as $fishId => $fishPosts) {
            
            $descPosts = $fishPosts->sortByDesc('size'); //投稿のsizeを比較して降順にpostを並べ替える

            // 各投稿のランキングを保存
            $rank = 1;
            //各投稿のに対してランキングをつけていく(for文で１ずつ足す)
            foreach ($descPosts as $post) {
                $post->ranking = $rank; //postのrank
                $post->save();
                $rank++;
            }

            // // ランキングを集計して保存
            // $ranking = new Ranking;
            // $ranking->start = $weekStart;
            // $ranking->end = $weekEnd;
            // //serializeとunserializeで配列として保存みたいなことができるらしい
            
            // $ranking->rank = $descPosts;
            // $ranking->num_of_participant = $fishPosts->count();
            // $ranking->fish_id = $fishId;
            // $ranking->save();
        }
    }
}
