<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Models\Partidos;

class PartidosController extends Controller
{
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
