<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Partidos, Vereadores};

class PartidosController extends Controller
{
    // Store Partido ...........................................
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
        
        // Armazena o logo
        $logoPath = $request->file('logo')->store('logos', 'public');
        $input['logo'] = $logoPath;

        Partidos::create($input);
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Vereador cadastrado com sucesso')
            ->with('active_tab', 'partidos');
    }

    // Edita Partido .......................................
    public function edit(Partidos $partido)
    {
        return view('videowall.edit', compact('partido'))
             ->with('active_tab', 'partidos');
    }

    // Update Partido ...........................................
    public function update(Request $request, Partidos $partido)
    {
        $input = $request->validate([
            'nome_partido' => 'required|string|max:255',
            'logo' => 'nullable|file|image|max:2048',
        ]);

        // Verifica se já existe outro partido com o mesmo nome
        $exists = Partidos::where('nome_partido', $input['nome_partido'])
                        ->where('id', '!=', $partido->id)
                        ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withErrors(['duplicado' => 'Partido já cadastrado com esse nome.'])
                ->withInput();
        }

        // Armazena o logo anterior antes de apagá-lo
        $oldLogo = $partido->logo;

        // Se houver uma nova logo, atualiza e remove a antiga
        if ($request->hasFile('logo')) {
            // Deleta logo anterior
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)){
                Storage::disk('public')->delete($oldLogo);
            }

             // Salva nova logo
             $newLogoPath = $request->file('logo')->store('logos', 'public');
             $input['logo'] = $newLogoPath;
 
             // Atualiza logo nos vereadores associados
             Vereadores::where('logo_partido', $oldLogo)
                       ->update(['logo_partido' => $newLogoPath]);
        } else {
            unset($input['logo']);
        }

        // Atualiza o partido com os dados novos
        $partido->update($input);

        return redirect()
            ->route('videowall.index')
            ->with('status', 'Partido atualizado com sucesso')
            ->with('active_tab', 'partidos');
    }
}
