<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedor';

    protected $fillable = [
        'nome', 'email', 'user_id'
    ];
}
