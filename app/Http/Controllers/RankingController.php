<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRankingRequest;
use App\Http\Requests\UpdateRankingRequest;
use App\Models\Ranking;

class RankingController extends Controller
{
    //
    public function index()
    {
        //
        $allranking = Ranking::all();
        return $allranking;
    }
}
