<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Blog Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.dark-mode {
            background-color: #121212;
            color: white !important;
        }
        body.dark-mode,
        body.dark-mode .navbar,
        body.dark-mode .navbar a,
        body.dark-mode .btn,
        body.dark-mode .btn-outline-dark,
        body.dark-mode .card,
        body.dark-mode .card * {
            color: white !important;
        }
        body.dark-mode .navbar {
            background-color: #1e1e1e !important;
        }
        body.dark-mode .btn-outline-dark {
            border-color: #fff;
            color: #fff;
        }
        body.dark-mode .btn-outline-dark:hover {
            background-color: #fff;
            color: #121212;
        }
        body.dark-mode .card {
            background-color: #1e1e1e !important;
            border-color: #333 !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <a class="navbar-brand" href="{{ route('posts.index') }}">My Blog</a>
    <button class="btn btn-sm btn-outline-dark ms-auto" onclick="toggleDarkMode()">🌓</button>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    document.documentElement.setAttribute('data-bs-theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>