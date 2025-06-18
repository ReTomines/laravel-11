<table class="table">

    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Setor</th>
            <th scope="col">Pavimento</th>
            <th scope="col">Icone</th>
            <th scope="col">Sala</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($setores as $setor)
            <tr>
                <th scope="row"> {{ $setor->id }} </th>
                <td> {{ $setor->nome_setor }} </td>
                <td> {{ $setor->localization->nome ?? 'N/D' }} </td>
                <td>
                    <img src="{{ asset('storage/' . $setor->icone) }}"
                        alt="Icone"
                        style="width: auto; height: 36px; object-fit: contain;">
                </td>
                <td> {{ $setor->sala }} </td>
                <td>
                    <form action="{{ route('videowall.setores.destroy', $setor->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        @can('edit', $setor)     
                            <a href="{{ route('videowall.setores.edit', $setor->id) }}" 
                               class="btn btn-sm btn-outline-primary"
                               title="Editar">
                               <i class="bi bi-pencil-square"></i>
                            </a>
                        @endcan   

                        @can('destroy', $setor)
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