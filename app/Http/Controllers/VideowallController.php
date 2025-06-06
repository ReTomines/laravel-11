<?php

namespace App\Http\Controllers;

use App\Models\{Setores, Partidos, Vereadores};
use App\Models\Localizations;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\DestroyableTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VideowallController extends Controller
{
    use AuthorizesRequests, DestroyableTrait;

    public function index()
    {
        $vereadores = Vereadores::with('localization')->get();
        $setores = Setores::with('localization')->get();
        $partidos = Partidos::get();

        return view('videowall.index', compact('vereadores', 'setores', 'partidos'));
    }

    public function create()
    {
        $pavimentos = Localizations::orderBy('nome', 'asc')->get();
        $partidos = Partidos::orderBy('nome_partido', 'asc')->get();
        //dd($pavimentos);
        return view('videowall.create', compact('pavimentos', 'partidos'));
    }

    public function destroyPartido(Partidos $partido)
    {
        return $this->destroy($partido);
    }

    public function destroySetor(Setores $setor)
    {
        return $this->destroy($setor);
    }
}
