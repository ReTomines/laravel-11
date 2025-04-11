<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // permite que os campos sejam preenchidos
    protected $fillable = [
        'type','document_number',
    ];
}
