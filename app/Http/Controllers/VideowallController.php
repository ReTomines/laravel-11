<?php

namespace App\Http\Controllers;

use App\Models\Setores;
use App\Models\Partidos;
use App\Models\Vereadores;
use App\Models\Localizations;
use Illuminate\Http\Request;


class VideowallController extends Controller
{
    public function index()
    {
        $vereadores = Vereadores::with('localization')->get();
        $setores = Setores::with('localization')->get();

        return view('videowall.index', compact('vereadores', 'setores'));
    }

    public function create()
    {
        $pavimentos = Localizations::orderBy('nome', 'asc')->get();
        //dd($pavimentos);
        return view('videowall.create', compact('pavimentos'));
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'nome_politico' => 'required|string|max:255',
            'titulo' => 'required|in:vereador,vereadora',
            'abrev_titulo' => 'nullable|string',
            'pavimento' => 'required|exists:localizations,id',
            'sala' => 'required|string|max:255',
            'logo_partido' => 'nullable|file|image|max:2048', // max 2MB
        ]);

        // Verifica se um arquivo foi enviado
        if ($request->hasFile('logo_partido')) {
            $logoPath = $request->file('logo_partido')->store('logos', 'public');
            $input['logo_partido'] = $logoPath;
        }

        Vereadores::create($input);
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso');
        }

        public function storeSetor(Request $request)
        {
            //dd($request->all());
            $input = $request->validate([
                'nome_setor' => 'required|string|max:255',
                'pavimento' => 'required|exists:localizations,id',
                'sala' => 'nullable|string|max:255',
                'icone' => 'nullable|file|image|max:2048',
            ]);
        
            // Verifica se um arquivo foi enviado
            if ($request->hasFile('icone')) {
                $iconePath = $request->file('icone')->store('icones', 'public');
                $input['icone'] = $iconePath;
            }
        
            Setores::create($input);
        
            return redirect()
                ->route('videowall.index')
                ->with('status', 'Setor cadastrado com sucesso');
        }

        public function storePartido(Request $request)
    {
        $input = $request->validate([
            'nome_partido' => 'required|string|max:255',
            'logo' => 'required|file|image|max:2048', // max 2MB
        ]);

        // Verifica se um arquivo foi enviado
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $input['logo'] = $logoPath;
        }

        Partidos::create($input);
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso');
        }
}
