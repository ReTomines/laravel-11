<div class="card small">
    <form action="{{route('users.updateInterests', $user->id)}}" method="post">
        @csrf
        @method('PUT') 
        <div class="card-header">
            <div>Interesses</div>
        </div>

        <div class="card-body">
            @foreach (['Opção1', 'Opção2'] as $interest)
            <div class="form-check">
                <input class="form-check-input" 
                       type="checkbox" 
                       value="{{ $interest }}"
                       name="interests[] [name]"
                >
                <label class="form-check-label">
                    {{ $interest }}
                </label>
            </div>
            @endforeach
        </div>
        @error('interests')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">Editar</button>
        </div>
    </form>
</div>    