<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
</head>

<body>

    <h1>Welcome to the Dashboard!</h1>

    <p>You have successfully logged in.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700">Logout</button>
    </form>

</body>
</html>