<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Club;
class Match extends Model
{
    Protected $table = 'matches';
    Protected $fillable = [
        'clubhome_id',
        'clubway_id',
        'score',
    ];

    public function match()
    {
        return $this->belongsToMany(Club::class);
    }
}
