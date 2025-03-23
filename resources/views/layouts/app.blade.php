<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
            border-right: 1px solid #dee2e6;
        }

        .sidebar a {
            padding: 8px 16px;
            text-decoration: none;
            font-size: 16px;
            color: #495057;
            display: block;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

    @auth
        <div class="sidebar">
            <h3>Menu</h3>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('pdfs.create') }}">Upload</a>
            <a href="#">Settings</a>
            <a href="{{ route('logout') }}">Logout</a>
        </div>

        <div class="content">
            @yield('content')
        </div>
    @else
        <div class="container">  <!-- Or any other container to wrap the content -->
            @yield('content')
        </div>
    @endauth

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>