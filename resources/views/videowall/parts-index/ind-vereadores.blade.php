<table class="table">

    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Vereador</th>
        <th scope="col">Partido</th>
        <th scope="col">Pavimento</th>
        <th scope="col">Sala</th>
        <th scope="col">Ação</th>

        </tr>
    </thead>


    <tbody>
        @foreach ($vereadores as $vereador)
            <tr>
                <th scope="row">{{ $vereador->id }}</th>
                <td> {{ $vereador->nome_politico }} </td>
                <td>
                    <img src="{{ asset('storage/' . $vereador->logo_partido) }}"
                        alt="Logo do Partido"
                        style="width: auto; height: 36px; object-fit: contain;">
                </td>
                <td> {{ $vereador->localization->nome ?? 'N/D' }} </td>
                <td> {{ $vereador->sala }} </td>
                <td>
                    <form action="{{ route('videowall.vereadores.destroy', $vereador->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        @can('edit', $vereador)     
                            <a href="{{ route('videowall.vereadores.edit', $vereador->id) }}" 
                               class="btn btn-sm btn-outline-primary"
                               title="Editar">
                               <i class="bi bi-pencil-square"></i>
                            </a>
                        @endcan    

                        @can('destroy', $vereador)
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger"
                                    title="Excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    
</table>