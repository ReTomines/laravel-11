<div class="card small">
    <form action="{{route('users.updateProfile', $user->id)}}" method="post">
        @csrf
        @method('PUT') 
        <div class="card-header">
            <div><b>Perfil</b></div>
        </div>
        <div class="card-body">

            <!-- Campo Tipo de pessoa -->
            <div class="mb-3">
                <label class="form-label">Tipo de pessoa:</label>
                <select name="type" 
                        class="form-control form-control-sm @error('type') is-invalid @enderror">
                        <option value="">Selecione</option>

                        @foreach (['PF', 'PJ'] as $type)
                            <option value="{{ $type }}" 
                                @selected(old('type', $user?->profile?->type ?? '') === $type)>
                                {{ $type }}
                            </option>
                        @endforeach
                </select>

                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo edereço -->	
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" 
                    name="address" 
                    class="form-control form-control-sm @error('address') is-invalid @enderror"
                    value="{{ old('address') ?? $user?->profile?->address }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Editar</button>
        </div>
    </form>
</div>    