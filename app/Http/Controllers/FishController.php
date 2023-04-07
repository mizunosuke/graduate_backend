<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;
use App\Models\Post;
use Carbon\Carbon;

class FishController extends Controller
{
    //
    public function index (Request $request)
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $limitedPosts = Post::where("fish_id", "=", $request->id)->orderby("size","desc")->get();
        return $limitedPosts;
    }
    
    public function fish ($id)
    {
        $fishname = Fish::find($id)->name;
        return $fishname;
    }
}
