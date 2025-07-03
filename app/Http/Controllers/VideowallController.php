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
        $vereadores = Vereadores::with('localization')->paginate(10);
        $setores = Setores::with('localization')->paginate(10);
        $partidos = Partidos::paginate(10);

        return view('videowall.index', compact('vereadores', 'setores', 'partidos'));
    }

    // Criar ...........................................
    public function create()
    {
        $pavimentos = Localizations::orderBy('nome', 'asc')->get();
        $partidos = Partidos::orderBy('nome_partido', 'asc')->get();
        $activeTab = request('tab', 'vereadores'); // valor da URL
        //dd($pavimentos);
        
        // Define flags com base na aba ativa
        $data = compact('pavimentos', 'partidos', 'activeTab');
        if ($activeTab === 'vereadores') {
            $data['vereador'] = true;
        } elseif ($activeTab === 'setores') {
            $data['setor'] = true;
        } elseif ($activeTab === 'partidos') {
            $data['partido'] = true;
        }

    return view('videowall.create', $data);
        
        //return view('videowall.create', compact('pavimentos', 'partidos', 'activeTab'));
    }

    // Deletar ...........................................
    public function destroyVereador(Vereadores $vereador)
    {
        return $this->destroy($vereador);
    }
    
    public function destroySetor(Setores $setor)
    {
        return $this->destroy($setor);
    }

    public function destroyPartido(Partidos $partido)
    {
        return $this->destroy($partido);
    }
}