<table class="table">

    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Setor</th>
            <th scope="col">Pavimento</th>
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
                <td> {{ $setor->sala }} </td>
                <td>
                    @can('destroy', $setor)
                        <form action="{{ route('videowall.setores.destroy', $setor->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
    
</table>