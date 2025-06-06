<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Models\Setores;

class SetoresController extends Controller
{
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
}
