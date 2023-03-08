<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;
use App\Models\Fish;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "attachment", "ranking_id", "size", "day_of_fishing"];


    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function fish ()
    {
        return $this->belongsTo(Fish::class);
    }
}
