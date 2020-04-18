<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    Protected $table = 'persons';
    Protected $fillable = [
        'first_name',
        'last_name',
        'created_at',
        'updated_at'
    ];
}
