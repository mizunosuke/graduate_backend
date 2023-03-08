<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = ["start", "end", "num_of_participant", "fish_id"];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}