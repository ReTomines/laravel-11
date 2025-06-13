<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Setores, Localizations};

class SetoresController extends Controller
{
    // Store Setor .........................................
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

        // Armazena o logo
        if ($request->hasFile('icone')) {
            $iconPath = $request->file('icone')->store('icones', 'public');
            $input['icone'] = $iconPath;
        }

        Setores::create($input);
        return redirect()
            ->route('videowall.index')
            ->with('status', 'Setor cadastrado com sucesso')
            ->with('active_tab', 'setores');
    }

    // Update Setor .......................................
    public function edit(Setores $setor)
    {
        $pavimentos = Localizations::all();
        return view('videowall.edit', compact('setor', 'pavimentos'))
             ->with('active_tab', 'setores');
    }

    public function update(Request $request, Setores $setor)
    {
        $input = $request->validate([
            'nome_setor' => 'required|string|max:255',
            'pavimento' => 'required|exists:localizations,id',
            'sala' => 'nullable|string|max:255',
            'icone' => 'nullable|file|image|max:2048',
        ]);

        // Verifica se já existe outro partido com o mesmo nome
        $exists = Setores::where('nome_setor', $input['nome_setor'])
                        ->where('id', '!=', $setor->id)
                        ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withErrors(['duplicado' => 'Setor já cadastrado com esse nome.'])
                ->withInput();
        }

        // Armazena o logo anterior antes de apagá-lo
        $oldIcone = $setor->icone;

        // Se houver uma nova icone, atualiza e remove a antiga
        if ($request->hasFile('icone')) {
            // Deleta icone anterior
            if ($oldIcone && Storage::disk('public')->exists($oldIcone)){
                Storage::disk('public')->delete($oldIcone);
            }

             // Salva nova logo
             $newIconePath = $request->file('icone')->store('icones', 'public');
             $input['icone'] = $newIconePath;
 
             // Atualiza logo nos vereadores associados
             Setores::where('icone', $oldIcone)
                    ->update(['icone' => $newIconePath]);
        } else {
            unset($input['icone']);
        }

        // Atualiza o partido com os dados novos
        $setor->update($input);

        return redirect()
            ->route('videowall.index')
            ->with('status', 'Setor atualizado com sucesso')
            ->with('active_tab', 'setores');
    }
}
