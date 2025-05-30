<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partidos extends Model
{
    protected $fillable = [
        'nome_partido', 'logo',
    ];
}
