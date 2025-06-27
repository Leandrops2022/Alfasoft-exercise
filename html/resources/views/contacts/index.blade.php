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

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #2c3e50;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px; /* Space between buttons/links */
        }

        .add-button, .auth-link, .logout-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer; /* For buttons */
        }

        .add-button:hover, .auth-link:hover, .logout-button:hover {
            background-color: #0056b3;
        }

        .logout-button {
            background-color: #dc3545; /* Red for logout */
            padding: 8px 12px; /* Slightly smaller padding for logout */
        }

        .logout-button:hover {
            background-color: #c82333;
        }

        .user-info {
            font-weight: bold;
            color: #2c3e50;
            margin-right: 10px;
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
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e2e6ea;
        }

        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            display: flex;
            align-items: center;
        }

        .pagination svg {
            width: 24px;
            height: 24px;
            color: #007bff;
        }

        td a, td button {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        td a:last-child, td button:last-child {
            margin-right: 0;
        }

        td a {
            background-color: #28a745;
            color: white;
        }

        td a:hover {
            background-color: #218838;
        }

        td form button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        td form button:hover {
            background-color: #c82333;
        }

        .restore-button {
            background-color: #007bff;
            color: white;
        }

        .restore-button:hover {
            background-color: #0056b3;
        }

        .deleted-row {
            background-color: #fde6e6;
        }

        .deleted-row td {
            text-decoration: line-through;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="main-header">
        <h1>Contact List</h1>
        <div class="header-actions">
            @auth
                <span class="user-info">Welcome, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
                <a href="{{ route('contacts.create') }}" class="add-button">Add New Contact</a>
            @else
                <a href="{{ route('login') }}" class="auth-link">Login</a>
                <a href="{{ route('register') }}" class="auth-link">Register</a>
            @endauth
        </div>
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
                        @auth
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
                        @endauth
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
