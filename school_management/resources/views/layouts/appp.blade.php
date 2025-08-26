<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #272635;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
        }
        body { background-color: #f5f7fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: linear-gradient(to bottom, var(--primary), var(--secondary)); color: white; height: 100vh; position: fixed; padding-top: 20px; box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1); }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); padding: 12px 20px; margin: 6px 0; border-radius: 5px; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background-color: rgba(255, 255, 255, 0.1); }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .main-content { margin-left: 250px; padding: 20px; }
        .navbar { background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
        @media (max-width: 768px) { .sidebar { width: 100%; height: auto; position: relative; margin-bottom: 20px; } .main-content { margin-left: 0; } }
        @yield('styles')
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar col-md-3 col-lg-2">
        <div class="text-center mb-4">
            <h3><i class="fas fa-graduation-cap"></i> School_System</h3>
            <p class="text-muted">Student Management System</p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link @yield('dashboard-active')" href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link @yield('students-active')" href="{{ url('/students') }}"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li class="nav-item"><a class="nav-link @yield('teachers-active')" href="{{ url('/teachers') }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
            <li class="nav-item"><a class="nav-link @yield('subjects-active')" href="{{ url('/subjects') }}"><i class="fas fa-book"></i> Subjects</a></li>
            <li class="nav-item"><a class="nav-link @yield('attendances-active')" href="{{ url('/attendances') }}"><i class="fas fa-clipboard-check"></i> Attendance</a></li>
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown">
                                <img src="https://via.placeholder.com/40" alt="User" width="40" height="40" class="rounded-circle me-2">
                                <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form id="logout-form-top" action="{{ route('logout') }}" method="POST">@csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForms = document.querySelectorAll('form[id^="logout-form"]');
            logoutForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to logout?')) e.preventDefault();
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>