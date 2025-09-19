<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Vision - Aj Kya Pakae')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Vision</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a href="{{ route('recipes.index') }}" class="nav-link">{{ __('messages.recipes') }}</a></li>
                    <li class="nav-item"><a href="{{ route('pantry.index') }}" class="nav-link">{{ __('messages.pantry') }}</a></li>
                    <li class="nav-item"><a href="{{ route('meal-plans.index') }}" class="nav-link">{{ __('messages.meal_planner') }}</a></li>
                    @auth
                        <li class="nav-item"><a href="#" class="nav-link">{{ __('messages.favorites') }}</a></li>
                        <li class="nav-item"><a href="{{ route('profile.edit') }}" class="nav-link">{{ __('messages.profile') }}</a></li>
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">{{ __('messages.admin') }}</a></li>
                        @endif
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">{{ __('messages.login') }}</a></li>
                    @endauth
                    
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            {{ app()->getLocale() == 'en' ? 'English' : 'اردو' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'ur') }}">اردو</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
