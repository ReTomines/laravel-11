<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vereadores extends Model
{
    protected $fillable = [
        'titulo', 'abrev_titulo', 'nome_politico', 'logo_partido', 'pavimento', 'sala'
    ];

    public function localization()
    {
        return $this->belongsTo(Localizations::class, 'pavimento');
    }
}