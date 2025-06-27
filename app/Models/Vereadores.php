<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vereadores extends Model
{
    protected $fillable = [
         'partido_id', 'nome_politico', 'foto_ver', 'titulo', 'abrev_titulo', 'pavimento', 'sala', 'logo_partido'
    ];

    public function partido()
    {
        return $this->belongsTo(Partidos::class, 'partido_id');
    }

    public function localization()
    {
        return $this->belongsTo(Localizations::class, 'pavimento');
    }

    protected static function booted()
    {
        static::deleting(function ($vereador) {
            if (!empty($vereador->foto_ver) && Storage::disk('public')->exists($vereador->foto_ver)) {
                Storage::disk('public')->delete($vereador->foto_ver);
            }
        });
    }
}
