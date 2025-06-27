<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f7f6;
            color: #333;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .back-button {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 30px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #5a6268;
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

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555; /* Cor da label */
        }

        .info-value {
            display: block; /* Para que o valor apareça em uma nova linha como um input */
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333; /* Cor do texto do valor */
            background-color: #f9f9f9; /* Fundo levemente diferente para o valor */
            box-sizing: border-box; /* Inclui padding e border na largura */
        }

        .button-group {
            margin-top: 4rem;
            text-align: center; /* Centraliza os botões */
        }

        .edit-button, .delete-button {
            display: inline-block; /* Para ficarem lado a lado */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            text-decoration: none; /* Remove sublinhado dos links */
            transition: background-color 0.3s ease;
            margin: 0 10px; /* Espaçamento entre os botões */
        }

        .edit-button {
            background-color: #4CAF50;
        }

        .delete-button {
            background-color: #f03a2d;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .delete-button:hover {
            background-color: #d9534f; /* Tom ligeiramente mais claro para o hover do delete */
        }

        /* Estilos não utilizados (da view de lista ou edição) */
        table, th, td, .pagination, .pagination svg, .deleted-row, .error-message {
            display: none;
        }
    </style>
</head>
<body>
    <a href="{{ route('contacts.index') }}" class="back-button">Back to list</a>

    <h1>Contact Details</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="info-group">
            <span class="info-label">Name</span>
            <span class="info-value">{{ $contact->name }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">Contact</span>
            <span class="info-value">{{ $contact->contact }}</span>
        </div>

        <div class="info-group">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $contact->email_address }}</span>
        </div>

        <div class="button-group">
            <a href="{{ route('contacts.edit', $contact->id) }}" class="edit-button">Edit</a>
            {{-- Formulário para o botão de Excluir --}}
            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delet this contact?')">Delete</button>
            </form>
        </div>
    </div>
</body>
</html>