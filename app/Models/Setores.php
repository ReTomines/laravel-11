<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setores extends Model
{
    protected $fillable = [
        'nome_setor', 'pavimento', 'sala', 'icone'
    ];

    public function localization()
    {
        return $this->belongsTo(Localization::class, 'pavimento');
    }
}
