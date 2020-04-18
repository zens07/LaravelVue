<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    Protected $table = 'clubs';
    Protected $fillable = [
        'name',
        'point'
    ];
}
