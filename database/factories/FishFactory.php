<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Fish;
use Illuminate\Support\Arr;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fish>
 */
class FishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Fish::class;

    public function definition(): array
    {
        $fishNames = [
            'マグロ', 'サーモン', 'カンパチ', 'ヒラメ', 'イカ',
            'タイ', 'ホッケ', 'サワラ', 'サバ', 'アジ',
            'カレイ', 'コウイカ', 'マダイ', 'クエ', 'サンマ',
            'ノドグロ', 'ハマチ', 'カツオ', 'ワカサギ', 'ツナ',
            'イセエビ', 'エビ', 'タコ', 'シャコ', 'アナゴ',
            'ウナギ', 'ホタテ', 'ホウボウ', 'タチウオ', 'マアジ',
            'イイダコ', 'ホワイトシュリンプ', 'キンメダイ', 'メバル', 'ギンダラ',
            'コハダ', 'キンメ', 'カサゴ', 'クロサギ', 'ヒメマス',
            'アユ', 'コイ', 'フナ', 'ニジマス', 'ヤマメ',
            'ヘラブナ', 'ヤツメウナギ', 'アマゴ', 'アブラコ', 'キジハタ',
        ];

        $randomFishName = Arr::shuffle($fishNames)[0];
        $key = array_search($randomFishName, $fishNames);
        unset($fishNames[$key]);

        return [
            'name' => $randomFishName,
        ];
    }
}
