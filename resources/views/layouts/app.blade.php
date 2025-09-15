<!DOCTYPE html>
<html>
<head>
    <title>My E-Commerce App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- optional -->
</head>
<body>
    <header>
        <h1>My App Header</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 My App</p>
    </footer>
</body>
</html>
