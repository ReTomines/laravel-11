{{-- Debug do usuário 
@auth
    <div>Logado como: {{ auth()->user()->name }}</div>
@else
    <div>Você não está autenticado.</div>
@endauth--}}

<table class="table">

    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Partido</th>
            <th scope="col">Logo</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($partidos as $partido)
            <tr>
                <th scope="row">{{ $partido->id }}</th>
                <td>{{ $partido->nome_partido }}</td>
                <td>
                    <img src="{{ asset('storage/' . $partido->logo) }}"
                        alt="Logo do Partido"
                        style="width: auto; height: 36px; object-fit: contain;">
                </td>
                <td>
                    <form action="{{ route('videowall.partidos.destroy', $partido->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        @can('edit', $partido)     
                            <a href="{{ route('videowall.partidos.edit', $partido->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        @endcan

                        @can('destroy', $partido)
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    
</table>