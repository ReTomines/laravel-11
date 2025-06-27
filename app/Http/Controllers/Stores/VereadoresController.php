<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Vereadores, Partidos, Localizations};

class VereadoresController extends Controller
{
    // Store Vereadores ...........................................
    public function store(Request $request)
    {
        $input = $request->validate([
            'nome_politico' => 'required|string|max:255',
            'foto_ver' => 'required|file|image|max:2048',
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

        // Buscar partido, se fornecido
        if (!empty($input['partido'])) {
            $partido = Partidos::find($input['partido']);
            if ($partido) {
                $input['logo_partido'] = $partido->logo; // Salva o logo no campo dos vereadores
                $input['partido_id'] = $partido->id;
            }
        }

        // Armazena o foto vereador ------
        $fotoPath = $request->file('foto_ver')->store('fotos', 'public');
        $input['foto_ver'] = $fotoPath;
        // fim do armazena o foto --------

        // Cria o vereador
        Vereadores::create($input);

        // Redireciona com sucesso
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso')
            ->with('active_tab', 'vereadores');
    }

    // Edita Vereador ...........................................
    public function edit(Vereadores $vereador)
    {
        $pavimentos = Localizations::all();
        $partidos = Partidos::all();

        return view('videowall.edit', compact('vereador', 'pavimentos', 'partidos'))
            ->with('active_tab', 'vereadores');
    }

    // Update Vereador ...........................................
    public function update(Request $request, Vereadores $vereador)
    {
        $input = $request->validate([
            'nome_politico' => 'required|string|max:255',
            'foto_ver' => 'required|file|image|max:2048',
            'titulo' => 'required|in:vereador,vereadora',
            'abrev_titulo' => 'nullable|string',
            'pavimento' => 'required|exists:localizations,id',
            'sala' => 'required|string|max:255',
            'partido' => 'nullable|exists:partidos,id',
        ]);

        // Verifica se já existe outro vereador com o mesmo nome
        $exists = Vereadores::where('nome_politico', $input['nome_politico'])
                            ->where('id', '!=', $vereador->id)
                            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withErrors(['duplicado' => 'Já existe um vereador com esse nome.'])
                ->withInput();
        }

        // Atualiza o vereador com os dados válidos
        $vereador->update($input);


        // Armazena o foto anterior antes de apagá-lo ---------
        $oldFoto = $vereador->foto_ver;

        // Se houver uma nova foto, atualiza e remove a antiga
        if ($request->hasFile('foto_ver')) {
            // Deleta foto anterior
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)){
                Storage::disk('public')->delete($oldFoto);
            }

             // Salva nova foto
             $newFotoPath = $request->file('foto_ver')->store('fotos', 'public');
             $input['logo'] = $newFotoPath;
 
        } else {
            unset($input['foto_ver']);
        }
        // fim do armazena foto -------------------------------


        // Atualiza o partido, se necessário
        if (!empty($input['partido'])) {
            $partido = Partidos::find($input['partido']);
            if ($partido) {
                $vereador->partido_id = $partido->id; // Atualiza o partido_id
                $vereador->logo_partido = $partido->logo; // Atualiza o logo do partido se ele estiver associado
                //dd($vereador->partido_id);
            }
        } else {
            // Se não houver partido, garante que o campo partido_id será null
            $vereador->partido_id = null;
            $vereador->logo_partido = null;  // Limpa o logo do partido
        }

        $vereador->update($input); // Atualiza o restante dos campos
        $vereador->save(); // Salva as alterações

        // Redireciona com sucesso
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador atualizado com sucesso!')
            ->with('active_tab', 'vereadores');
    }
}
