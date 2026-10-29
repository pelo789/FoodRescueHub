<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Food Rescue Hub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        .navbar {
            background: #2563eb;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .logout-btn {
            background: white;
            color: #2563eb;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .welcome h1 {
            margin-top: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            margin-top: 0;
            color: #2563eb;
        }

        @media (max-width: 700px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Food Rescue Hub</h2>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Welcome!</h1>

            @auth
                <p>
                    Hello, {{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}.
                </p>

                <p>
                    You are logged in successfully.
                </p>
            @endauth
        </div>

        <div class="cards">

            <div class="card">
                <h3>Food Rescue</h3>
                <p>
                    Help reduce food waste by connecting available food
                    with people who need it.
                </p>
            </div>

            <div class="card">
                <h3>My Account</h3>
                <p>
                    Your account information can be managed here.
                </p>
            </div>

            <div class="card">
                <h3>Status</h3>
                <p>
                    Your account is currently active.
                </p>
            </div>

        </div>

    </div>

</body>
</html>