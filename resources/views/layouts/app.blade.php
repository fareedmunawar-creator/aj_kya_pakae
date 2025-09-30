<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Aaj Kya Pakae'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- Modern Theme -->
    <link href="{{ asset('css/modern-theme.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm fade-in" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold gradient-text pulse" href="{{ route('home') }}">
                <i class="bi bi-egg-fried me-2 rotate-icon"></i>Vision
            </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link nav-link-fancy {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-1 nav-icon"></i> {{ __('messages.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('about.index') }}" class="nav-link nav-link-fancy {{ request()->routeIs('about.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-week me-1 nav-icon"></i> {{ __('About') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('recipes.index') }}" class="nav-link nav-link-fancy {{ request()->routeIs('recipes.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-text me-1 nav-icon"></i> {{ __('messages.recipes') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pantry.index') }}" class="nav-link nav-link-fancy {{ request()->routeIs('pantry.*') ? 'active' : '' }}">
                            <i class="bi bi-basket me-1 nav-icon"></i> {{ __('messages.pantry') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('meal-plans.index') }}" class="nav-link nav-link-fancy {{ request()->routeIs('meal-plans.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-week me-1 nav-icon"></i> {{ __('messages.meal_planner') }}
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('favorites.index') }}" class="nav-link nav-link-fancy {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                                <i class="bi bi-heart-fill me-1 nav-icon text-danger pulse"></i> {{ __('messages.favorites') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('quick.cook.get') }}" class="nav-link nav-link-fancy {{ request()->routeIs('quick.cook*') ? 'active' : '' }}">
                                <i class="bi bi-lightning-charge-fill me-1 nav-icon text-warning pulse"></i> {{ __('Quick Cook') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-link-fancy" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1 nav-icon"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 slide-in-up" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item hover-lift" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-fill me-2 text-primary"></i>{{ __('messages.profile') }}
                                    </a>
                                </li>
                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item hover-lift" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2 text-success"></i>{{ __('messages.admin') }}
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item hover-lift">
                                            <i class="bi bi-box-arrow-right me-2 text-danger"></i>{{ __('messages.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link nav-link-fancy btn-sm btn-gold hover-lift px-3 py-1 ms-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('messages.login') }}
                            </a>
                        </li>
                    @endauth
                    
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-fancy" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-globe-americas me-1 nav-icon text-info pulse"></i> {{ app()->getLocale() == 'en' ? 'English' : 'اردو' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 slide-in-up" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item hover-lift" href="{{ route('language.switch', 'en') }}"><span class="flag-icon me-2">🇺🇸</span>English</a></li>
                            <li><a class="dropdown-item hover-lift" href="{{ route('language.switch', 'ur') }}"><span class="flag-icon me-2">🇵🇰</span>اردو</a></li>
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
    <footer class="mt-auto fade-in" style="background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);">
        <div class="footer-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f8f9fa" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
        </div>
        <div class="container py-5">
            <div class="row gy-4 slide-in-up">
                <div class="col-lg-5 col-md-6">
                    <h4 class="fw-bold gradient-text mb-4"><i class="bi bi-egg-fried me-2 rotate-icon"></i>Vision - Aj Kya Pakae</h4>
                    <p class="text-white mb-4">Your ultimate cooking companion for creating delicious meals with ease. Discover recipes, plan meals, and organize your pantry all in one place.</p>
                    <div class="social-icons d-flex gap-3 mb-4">
                        <a href="#" class="social-icon-link pulse"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="social-icon-link pulse"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="social-icon-link pulse"><i class="bi bi-twitter-x fs-4"></i></a>
                        <a href="#" class="social-icon-link pulse"><i class="bi bi-pinterest fs-4"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold text-white mb-4 footer-heading">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('home') }}" class="footer-link hover-lift"><i class="bi bi-chevron-right me-1"></i>Home</a></li>
                        <li class="mb-2"><a href="{{ route('recipes.index') }}" class="footer-link hover-lift"><i class="bi bi-chevron-right me-1"></i>Recipes</a></li>
                        <li class="mb-2"><a href="{{ route('pantry.index') }}" class="footer-link hover-lift"><i class="bi bi-chevron-right me-1"></i>Pantry</a></li>
                        <li class="mb-2"><a href="{{ route('meal-plans.index') }}" class="footer-link hover-lift"><i class="bi bi-chevron-right me-1"></i>Meal Planner</a></li>
                        <li class="mb-2"><a href="/about" class="footer-link hover-lift"><i class="bi bi-chevron-right me-1"></i>About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold text-white mb-4 footer-heading">Features</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('quick.cook.get') }}" class="footer-link hover-lift"><i class="bi bi-lightning-charge me-1"></i>Quick Cook</a></li>
                        <li class="mb-2"><a href="{{ route('favorites.index') }}" class="footer-link hover-lift"><i class="bi bi-heart me-1"></i>Favorites</a></li>
                        <li class="mb-2"><a href="#" class="footer-link hover-lift"><i class="bi bi-star me-1"></i>Popular Recipes</a></li>
                        <li class="mb-2"><a href="#" class="footer-link hover-lift"><i class="bi bi-calendar-event me-1"></i>Seasonal Dishes</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold text-white mb-4 footer-heading">Contact</h5>
                    <ul class="list-unstyled footer-contact">
                        <li class="d-flex mb-3 hover-lift"><i class="bi bi-envelope-fill me-2 text-white"></i><span>contact@vision.com</span></li>
                        <li class="d-flex mb-3 hover-lift"><i class="bi bi-telephone-fill me-2 text-white"></i><span>+92 123 456 7890</span></li>
                        <li class="d-flex hover-lift"><i class="bi bi-geo-alt-fill me-2 text-white"></i><span>Karachi, Pakistan</span></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-white opacity-25">
            <div class="text-center text-white">
                <p class="mb-0">&copy; {{ date('Y') }} Vision. All rights reserved. <span class="pulse">❤️</span> Made with love for cooking enthusiasts.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Modal Fix Script -->
    <script src="{{ asset('js/modal-fix.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
