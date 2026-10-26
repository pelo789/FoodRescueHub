<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 15px #00000015;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Login</h2>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <label>Email Address</label>
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               required>

        <label>Password</label>
        <input type="password"
               name="password"
               required>

        <button type="submit">Login</button>
    </form>

    <p>
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>

</div>

</body>
</html>