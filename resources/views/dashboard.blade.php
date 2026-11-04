
@php
    $user = auth()->user();

    $role = strtolower(str_replace(' ', '_', trim($user->role ?? '')));

    $isAdmin = $role === 'administrator';
    $isProvider = $role === 'food_provider';
    $isRecipient = $role === 'recipient_organization';

    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

    if ($fullName === '') {
        $fullName = $user->name ?? 'User';
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FoodRescue Hub - Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        .sidebar {
            width: 220px;
            background: white;
            position: fixed;
            height: 100%;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #eee;
        }

        .main {
            margin-left: 260px;
            padding: 25px;
        }

        .header {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .section {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .stat-box {
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
            flex: 1;
            min-width: 130px;
        }

        .stat-box h3 {
            font-size: 14px;
            font-weight: normal;
        }

        .stat-box p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 0;
        }

        button {
            padding: 8px 15px;
            cursor: pointer;
        }

        @media (max-width: 700px) {
            .sidebar {
                position: static;
                width: auto;
                height: auto;
            }

            .main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>FoodRescue Hub</h2>

        <a href="{{ route('dashboard') }}">Dashboard</a>

        @if ($isAdmin)
            <a href="#">Organizations</a>
            <a href="#">Verification Requests</a>
            <a href="#">User Management</a>
            <a href="#">Reports</a>
            <a href="#">Audit Logs</a>

        @elseif ($isProvider)
            <a href="#">Food Listings</a>
            <a href="#">Inventory Management</a>
            <a href="#">Food Requests</a>
            <a href="#">Pickup Schedules</a>
            <a href="#">Redistribution History</a>

        @elseif ($isRecipient)
            <a href="#">Browse Available Food</a>
            <a href="#">My Requests</a>
            <a href="#">Pickup Schedules</a>
            <a href="#">Received Food</a>

        @else
            <p>Unrecognized user role.</p>
        @endif

        <a href="#">My Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="main">

        <div class="header">
            <h2>Welcome, {{ $fullName }}!</h2>
            <p>
                Role:
                @if ($isAdmin)
                    Administrator
                @elseif ($isProvider)
                    Food Provider
                @elseif ($isRecipient)
                    Recipient Organization
                @else
                    Unknown Role ({{ $user->role }})
                @endif
            </p>
        </div>

        {{-- ADMINISTRATOR DASHBOARD --}}
        @if ($isAdmin)

            <h2>Administrator Dashboard</h2>

            <div class="stats">
                <div class="stat-box">
                    <h3>Total Organizations</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Pending Verifications</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Active Food Listings</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Completed Redistributions</h3>
                    <p>0</p>
                </div>
            </div>

            <div class="section">
                <h3>Recent System Activities</h3>
                <p>No recent activities available.</p>
            </div>

        {{-- FOOD PROVIDER DASHBOARD --}}
        @elseif ($isProvider)

            <h2>Food Provider Dashboard</h2>

            <div class="stats">
                <div class="stat-box">
                    <h3>Active Food Listings</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Pending Requests</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Food Nearing Expiration</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Upcoming Pickups</h3>
                    <p>0</p>
                </div>
            </div>

            <div class="section">
                <h3>Recent Food Listings</h3>
                <p>No food listings available.</p>
            </div>

        {{-- RECIPIENT ORGANIZATION DASHBOARD --}}
        @elseif ($isRecipient)

            <h2>Recipient Organization Dashboard</h2>

            <div class="stats">
                <div class="stat-box">
                    <h3>Available Food Listings</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>My Submitted Requests</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Approved Requests</h3>
                    <p>0</p>
                </div>

                <div class="stat-box">
                    <h3>Upcoming Pickups</h3>
                    <p>0</p>
                </div>
            </div>

            <div class="section">
                <h3>Recent Requests</h3>
                <p>No requests available.</p>
            </div>

        @else

            <div class="section">
                <h3>Access Restricted</h3>
                <p>Your account does not have a recognized FoodRescue Hub role.</p>
                <p>Please contact the administrator.</p>
            </div>

        @endif

    </div>

</body>
</html>
