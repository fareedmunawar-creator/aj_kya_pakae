<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vision - Aj Kya Pakae')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-egg-fried me-2"></i>Vision
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-1"></i> {{ __('messages.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('recipes.index') }}" class="nav-link {{ request()->routeIs('recipes.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-text me-1"></i> {{ __('messages.recipes') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pantry.index') }}" class="nav-link {{ request()->routeIs('pantry.*') ? 'active' : '' }}">
                            <i class="bi bi-basket me-1"></i> {{ __('messages.pantry') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('meal-plans.index') }}" class="nav-link {{ request()->routeIs('meal-plans.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-week me-1"></i> {{ __('messages.meal_planner') }}
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('favorites.toggle', ['recipe' => 0]) }}" class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" onclick="event.preventDefault(); window.location.href='/favorites';">
                                <i class="bi bi-heart me-1"></i> {{ __('messages.favorites') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('quick-cook') }}" class="nav-link {{ request()->routeIs('quick-cook') ? 'active' : '' }}">
                                <i class="bi bi-lightning-charge me-1"></i> {{ __('Quick Cook') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i>{{ __('messages.profile') }}
                                    </a>
                                </li>
                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>{{ __('messages.admin') }}
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('messages.login') }}
                            </a>
                        </li>
                    @endauth
                    
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-globe me-1"></i> {{ app()->getLocale() == 'en' ? 'English' : 'اردو' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'ur') }}">اردو</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4 flex-grow-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-6">
                    <h5 class="fw-bold"><i class="bi bi-egg-fried me-2"></i>Vision - Aj Kya Pakae</h5>
                    <p class="text-light">Your ultimate cooking companion for delicious meals.</p>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-light"><i class="bi bi-chevron-right me-1"></i>Home</a></li>
                        <li><a href="{{ route('recipes.index') }}" class="text-decoration-none text-light"><i class="bi bi-chevron-right me-1"></i>Recipes</a></li>
                        <li><a href="{{ route('pantry.index') }}" class="text-decoration-none text-light"><i class="bi bi-chevron-right me-1"></i>Pantry</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold">Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope-fill me-2"></i>contact@vision.com</li>
                        <li><i class="bi bi-telephone-fill me-2"></i>+92 123 456 7890</li>
                        <li><i class="bi bi-geo-alt-fill me-2"></i>Karachi, Pakistan</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Vision. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
