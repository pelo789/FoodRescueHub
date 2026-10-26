<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

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
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
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

        .error {
            color: red;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Register</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <label>First Name</label>
        <input type="text"
               name="first_name"
               value="{{ old('first_name') }}"
               maxlength="100"
               required>

        <label>Last Name</label>
        <input type="text"
               name="last_name"
               value="{{ old('last_name') }}"
               maxlength="100"
               required>

        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               maxlength="150"
               required>

        <label>Phone</label>
        <input type="tel"
               name="phone"
               value="{{ old('phone') }}"
               maxlength="20">

        <label>Address</label>
        <input type="text"
               name="address"
               value="{{ old('address') }}"
               maxlength="255">

        <label>Password</label>
        <input type="password"
               name="password"
               minlength="8"
               required>

        <label>Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               minlength="8"
               required>

        <button type="submit">Register</button>
    </form>

    <p>
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </p>

</div>

</body>
</html>