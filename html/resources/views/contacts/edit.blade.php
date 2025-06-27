<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
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

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto; 
        }

        .form-group {
            margin-bottom: 20px; 
        }

        .form-group label {
            display: block; 
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] { 
            width: calc(100% - 20px); 
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .save-button {
            background-color: #4CAF50; 
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 4rem; 
            display: block; 
            width: 100%;
            max-width: 200px; 
            margin-left: auto; 
            margin-right: auto;
            transition: background-color 0.3s ease; 
        }

        .save-button:hover {
            background-color: #45a049; 
        }

    </style>
</head>
<body>
    <a href="{{ route('contacts.index') }}" class="back-button">Back to list</a>

    <h1>Edit Contact</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red; background-color: #ffe6e6; border: 1px solid #ffcccc; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
      
        <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
              
                <input type="text" id="name" name="name" value="{{ old('name', $contact->name) }}">
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" value="{{ old('contact', $contact->contact) }}">
            </div>

            <div class="form-group">
                <label for="email_address">Email</label>
                <input type="email" id="email_address" name="email_address" value="{{ old('email_address', $contact->email_address) }}">
            </div>

            <button type="submit" class="save-button">Save</button>
        </form>
    </div>
</body>
</html>