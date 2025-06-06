<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

trait DestroyableTrait
{
    public function destroy(Model $model): RedirectResponse
    {
        $this->authorize('destroy', $model);

        $model->delete();

        return back()->with('status', class_basename($model) . ' deletado com sucesso');
    }
}
