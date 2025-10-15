<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    <style>
        :root {
            --ios-blue: #007AFF;
            --ios-purple: #5856D6;
            --ios-green: #34C759;
            --ios-orange: #FF9500;
            --ios-red: #FF3B30;
            --ios-gray: #F2F2F7;
            --ios-gray-2: #E5E5EA;
            --ios-gray-3: #D1D1D6;
            --ios-gray-4: #C7C7CC;
            --ios-gray-5: #AEAEB2;
            --ios-gray-6: #8E8E93;
            --ios-label: #000000;
            --ios-secondary-label: #3C3C43;
            --ios-tertiary-label: #3C3C4399;
            --ios-quaternary-label: #3C3C432E;
            --ios-system-background: #FFFFFF;
            --ios-secondary-background: #F2F2F7;
            --ios-tertiary-background: #FFFFFF;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --ios-label: #FFFFFF;
                --ios-secondary-label: #EBEBF5;
                --ios-tertiary-label: #EBEBF599;
                --ios-quaternary-label: #EBEBF52E;
                --ios-system-background: #000000;
                --ios-secondary-background: #1C1C1E;
                --ios-tertiary-background: #2C2C2E;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--ios-blue) 0%, var(--ios-purple) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--ios-label);
            margin-bottom: 8px;
        }

        .auth-subtitle {
            font-size: 16px;
            color: var(--ios-secondary-label);
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--ios-label);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid var(--ios-gray-4);
            border-radius: 12px;
            font-size: 16px;
            background: var(--ios-system-background);
            color: var(--ios-label);
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--ios-blue);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
        }

        .form-input::placeholder {
            color: var(--ios-tertiary-label);
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: var(--ios-blue);
            color: white;
        }

        .btn-primary:hover {
            background: #0056CC;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 122, 255, 0.3);
        }

        .btn-secondary {
            background: var(--ios-gray-2);
            color: var(--ios-label);
            margin-top: 12px;
        }

        .btn-secondary:hover {
            background: var(--ios-gray-3);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .form-check-input {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            accent-color: var(--ios-blue);
        }

        .form-check-label {
            font-size: 14px;
            color: var(--ios-secondary-label);
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-danger {
            background: rgba(255, 59, 48, 0.1);
            color: var(--ios-red);
            border: 1px solid rgba(255, 59, 48, 0.2);
        }

        .alert-success {
            background: rgba(52, 199, 89, 0.1);
            color: var(--ios-green);
            border: 1px solid rgba(52, 199, 89, 0.2);
        }

        .text-center {
            text-align: center;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .text-link {
            color: var(--ios-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .auth-container {
                padding: 30px 20px;
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>