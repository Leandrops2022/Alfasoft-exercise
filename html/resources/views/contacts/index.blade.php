<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pagination { margin-top: 20px; }
        .pagination svg { width: 20px; } 
        .deleted-row { background-color: #ffe6e6; } 
        .deleted-row td { text-decoration: line-through; color: #888; }
    </style>
</head>
<body>
    <h1>Contact List</h1>

    @if (session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $contact)
                {{-- Adiciona classe para linhas soft-deletadas --}}
                <tr @if($contact->trashed()) class="deleted-row" @endif>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->contact }}</td>
                    <td>
                       
                        <a href="{{ route('contacts.edit', $contact->id) }}">Editar</a>

                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            {{-- Botão para deletar --}}
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este contato?')" style="background: none; border: none; color: red; cursor: pointer; text-decoration: underline;">Excluir</button>
                        </form>

                        @if($contact->trashed())
                            <form action="{{ route('contacts.restore', $contact->id) }}" method="POST" style="display:inline; margin-left: 10px;">
                                @csrf
                                @method('PUT') {{-- Ou PATCH, para restaurar --}}
                                <button type="submit" onclick="return confirm('Tem certeza que deseja restaurar este contato?')" style="background: none; border: none; color: blue; cursor: pointer; text-decoration: underline;">Restaurar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum contato encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Links de Paginação --}}
    <div class="pagination">
        {{ $contacts->links() }}
    </div>

</body>
</html>