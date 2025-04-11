<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    // etrutura do model
    // config. gerais do model
    // relações (1->1, 1->N, N->N)
}
