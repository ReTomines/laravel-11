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
        $partidos = Partidos::orderBy('nome_partido', 'asc')->get();
        //dd($pavimentos);
        return view('videowall.create', compact('pavimentos', 'partidos'));
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'nome_politico' => 'required|string|max:255',
            'titulo' => 'required|in:vereador,vereadora',
            'abrev_titulo' => 'nullable|string',
            'pavimento' => 'required|exists:localizations,id',
            'sala' => 'required|string|max:255',
            'partido' => 'nullable|exists:partidos,id', // max 2MB
        ]);

        $exists = Vereadores::where('nome_politico', $input['nome_politico'])->exists();
        if ($exists) {
            return redirect()
                ->route('videowall.create')
                ->withErrors(['duplicado' => 'Vereador já cadastrado com esse nome.'])
                ->withInput()
                ->with('active_tab', 'vereadores');
        }

        /* // Verifica se um arquivo foi enviado
        if ($request->hasFile('logo_partido')) {
            $logoPath = $request->file('logo_partido')->store('logos', 'public');
            $input['logo_partido'] = $logoPath;
        }*/

        Vereadores::create($input);
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso');
    }

    //** storeSetor
    public function storeSetor(Request $request)
    {
        //dd($request->all());
        $input = $request->validate([
            'nome_setor' => 'required|string|max:255',
            'pavimento' => 'required|exists:localizations,id',
            'sala' => 'nullable|string|max:255',
            'icone' => 'nullable|file|image|max:2048',
        ]);
        
        $exists = Setores::where('nome_setor', $input['nome_setor'])->exists();
        if ($exists) {
            return redirect()
                ->route('videowall.create')
                ->withErrors(['duplicado' => 'Setor já cadastrado com esse nome.'])
                ->withInput()
                ->with('active_tab', 'setores');
        }

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

    //** storePartido
    public function storePartido(Request $request)
    {
        $input = $request->validate([
            'nome_partido' => 'required|string|max:255',
            'logo' => 'required|file|image|max:2048', // max 2MB
        ]);

        $exists = Partidos::where('nome_partido', $input['nome_partido'])->exists();
        if ($exists) {
            return redirect()
                ->route('videowall.create')
                ->withErrors(['duplicado' => 'Partido já cadastrado com esse nome.'])
                ->withInput()
                ->with('active_tab', 'partidos');
        }

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
