<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index (Request $request, int $id) 
    {
        
    }

    // public function withpost (Request $request, int $id)
    // {
    //     $start = Carbon::now()->startOfWeek();
    //     $end = Carbon::now()->endOfWeek();
    //     $limitedPost = Post::where('ranking_id', $id)->whereBetween("day_of_fishing", [$start, $end])->orderBy('size', 'desc')->take(3)->get();
    //     return $limitedPost;
    // } 
}
