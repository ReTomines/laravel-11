<?php

namespace App\Http\Controllers;

use App\Models\Vereadores;
use App\Models\Localizations;
use Illuminate\Http\Request;


class VideowallController extends Controller
{
    public function index()
    {
        return view('videowall.index');
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
}
