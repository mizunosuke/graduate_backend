<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Fish;
use App\Models\Ranking;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->count(10)->create();
        Fish::factory()->count(10)->create();
        Post::factory()->count(30)->create();
        Ranking::factory()->count(10)->create();

        
    }
}
