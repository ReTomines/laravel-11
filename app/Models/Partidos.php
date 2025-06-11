<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partidos extends Model
{
    protected $fillable = [
        'nome_partido', 'logo',
    ];

    /**
     * Evento que é disparado quando um registro está prestes a ser deletado.
     * Se o campo `logo` existir e o arquivo estiver presente no disco `public`,
     * o arquivo será excluído automaticamente.
     */
    protected static function booted()
    {
        static::deleting(function ($partido) {
            if (!empty($partido->logo) && Storage::disk('public')->exists($partido->logo)) {
                Storage::disk('public')->delete($partido->logo);
            }
        });
    }
}
