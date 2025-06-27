<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f7f6;
            color: #333;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #2c3e50;
            margin: 0; /* Remove default margin */
        }

        .add-button {
            display: inline-block;
            background-color: #007bff; /* Um tom de azul padrão para "adicionar" */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            margin-bottom: 15px;
            background-color: #e6ffe6;
            border: 1px solid #cce6cc;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Para border-radius na tabela */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px; /* Mais padding */
            text-align: left;
        }

        th {
            background-color: #e9ecef; /* Um cinza mais claro */
            color: #495057;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa; /* Listras para melhor legibilidade */
        }

        tr:hover {
            background-color: #e2e6ea; /* Efeito hover na linha */
        }

        .pagination {
            margin-top: 30px;
            display: flex; /* Para centralizar os links de paginação */
            justify-content: center;
        }

        .pagination nav {
            display: flex;
            align-items: center;
        }

        .pagination svg {
            width: 24px; /* Aumenta um pouco o ícone da paginação */
            height: 24px;
            color: #007bff; /* Cor do ícone */
        }

        /* Estilos para os botões de ação na tabela */
        td a, td button {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px; /* Espaço entre os botões */
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        td a:last-child, td button:last-child {
            margin-right: 0;
        }

        td a {
            background-color: #28a745; /* Edit Button: Green */
            color: white;
        }

        td a:hover {
            background-color: #218838;
        }

        td form button {
            background-color: #dc3545; /* Delete Button: Red */
            color: white;
            border: none;
            cursor: pointer;
        }

        td form button:hover {
            background-color: #c82333;
        }

        .restore-button {
            background-color: #007bff; /* Restore Button: Blue */
            color: white;
        }

        .restore-button:hover {
            background-color: #0056b3;
        }

        .deleted-row {
            background-color: #fde6e6; /* Cor mais suave para deletados */
        }

        .deleted-row td {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <h1>Contact List</h1>
        <a href="{{ route('contacts.create') }}" class="add-button">Add New Contact</a>
    </div>

    @if (session('success'))
        <div class="success-message">
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
                <tr @if($contact->trashed()) class="deleted-row" @endif>
                    <td>
                        <a href="{{ route('contacts.show', $contact->id) }}">{{ $contact->name }}</a>
                    </td>
                    <td>{{ $contact->contact }}</td>
                    <td>
                        <a href="{{ route('contacts.edit', $contact->id) }}">Edit</a>

                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this contact?')" class="delete-button">Delete</button>
                        </form>

                        @if($contact->trashed())
                            <form action="{{ route('contacts.restore', $contact->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to restore this contact?')" class="restore-button">Restore</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No contacts were found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $contacts->links() }}
    </div>

</body>
</html>
