<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Models\{Vereadores, Partidos};

class VereadoresController extends Controller
{
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

        // Verifica se existe um vereador com o mesmo nome
        $exists = Vereadores::where('nome_politico', $input['nome_politico'])->exists();
        if ($exists) {
            return redirect()
                ->route('videowall.create')
                ->withErrors(['duplicado' => 'Vereador já cadastrado com esse nome.'])
                ->withInput()
                ->with('active_tab', 'vereadores');
        }

        // Buscar logo do partido
        $partido = null; // Inicia partido como nulo
        if (!empty($input['partido'])) {
            $partido = Partidos::find($input['partido']);
            if ($partido) {
                $input['logo_partido'] = $partido->logo; // Salva o logo no campo dos vereadores
            }
        }

        unset($input['partido']); // evitar erro se não estiver no fillable
        Vereadores::create($input); // cria o vereador

        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso');
    }
}
