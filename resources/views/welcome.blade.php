<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'School Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            text-align: center;
            color: white;
            max-width: 600px;
        }
        
        .logo {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            margin: 0 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .features {
            margin-top: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .feature {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .feature h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .feature p {
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">🏫 School Management</div>
        <div class="subtitle">Modern school management system with iOS 16 design</div>
        
        <div>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn">Admin Dashboard</a>
                @elseif(Auth::user()->isTeacher())
                    <a href="{{ route('teacher.dashboard') }}" class="btn">Teacher Dashboard</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn">Login</a>
                @if(!App\Models\User::where('role', 'admin')->exists())
                    <a href="{{ route('register') }}" class="btn">Setup Admin</a>
                @endif
            @endauth
        </div>
        
        <div class="features">
            <div class="feature">
                <h3>📰 News & Events</h3>
                <p>Manage school news and upcoming events</p>
            </div>
            <div class="feature">
                <h3>🎓 Competency Programs</h3>
                <p>Showcase educational programs and competencies</p>
            </div>
            <div class="feature">
                <h3>📸 Gallery</h3>
                <p>Share school activities and achievements</p>
            </div>
            <div class="feature">
                <h3>📝 PPDB Registration</h3>
                <p>Online student registration system</p>
            </div>
        </div>
    </div>
</body>
</html>