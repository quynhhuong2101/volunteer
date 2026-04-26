<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Volunteer Connect') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fallback style for preview without Vite build -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F4C81',
                        accent: '#FF6D00',
                        neutral: {
                            bg: '#F4F7FE',
                            surface: '#FFFFFF',
                        }
                    },
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-900 bg-neutral-bg">
    @yield('content')
</body>
</html>
