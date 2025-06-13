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
                <td> {{ $setor->pavimento }} </td>
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
                            <a href="{{ route('videowall.setores.edit', $setor->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        @endcan   

                        @can('destroy', $setor)
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        @endcan
                    </form>                    
                </td>
            </tr>
        @endforeach
    </tbody>
    
</table>