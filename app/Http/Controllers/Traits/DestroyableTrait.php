<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

trait DestroyableTrait
{
    public function destroy(Model $model): RedirectResponse
    {
        $this->authorize('destroy', $model);

        // Deleta a imagem se existir e o modelo tiver o atributo "logo"
        if (!empty($model->logo) && Storage::disk('public')->exists($model->logo)) {
            Storage::disk('public')->delete($model->logo);
        }

        $model->delete();

        return back()->with('status', class_basename($model) . ' deletado com sucesso');
    }
}
