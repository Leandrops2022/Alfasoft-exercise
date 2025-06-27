<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .error-message {
            color: red;
            background-color: #ffe6e6;
            border: 1px solid #ffcccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }
        .error-message p {
            margin: 0;
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
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .submit-button {
            background-color: #007bff; /* Blue for primary actions */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 2rem;
            display: block;
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        .form-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .form-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="{{ route('contacts.index') }}" class="back-button">Back to Home</a>

    <h1>Login</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            @if($errors->has('email') && count($errors->all()) === 1)
                <p>{{ $errors->first('email') }}</p>
            @else
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="submit-button">Login</button>
        </form>
        <a href="{{ route('register') }}" class="form-link">Don't have an account? Register here.</a>
    </div>
</body>
</html>
