<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TOSHOP Admin')</title>
    
    <!-- CDN Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr2wGrXdLKS5BqgKrII7HfWVX2ZBj" 
          crossorigin="anonymous">
    
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    
    @yield('head')
</head>
<body>
        <!-- Admin Sidebar -->
        @include('_admin_navigation')
    
        <!-- Page Content -->
        @yield('content')

    </div>
    
    @yield('scripts')
</body>
</html>