<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-egg-fried me-2"></i>Vision
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        {{ __('Home') }}
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('recipes.*') ? 'active' : '' }}" href="{{ route('recipes.index') }}">
                        {{ __('Recipes') }}
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('mealplanner.*') ? 'active' : '' }}" href="{{ route('mealplanner.index') }}">
                        {{ __('Meal Planner') }}
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pantry.*') ? 'active' : '' }}" href="{{ route('pantry.index') }}">
                        {{ __('Pantry') }}
                    </a>
                </li>
                
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}">
                        {{ __('Favorites') }}
                    </a>
                </li>
                @endauth
                
                @if(auth()->check() && auth()->user()->isAdmin())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                        {{ __('Admin') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.recipes.index') }}">{{ __('Recipes') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.recipes.create') }}">{{ __('Add Recipe') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.ingredients.index') }}">{{ __('Ingredients') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.meal-plans.index') }}">{{ __('Meal Plans') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
                    </ul>
                </li>
                @endif
            </ul>

            <!-- User Dropdown -->
            @auth
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>
                        
                        <!-- Authentication -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @else
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </li>
            </ul>
            @endauth

            <!-- Language Switcher -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                        {{ app()->getLocale() == 'en' ? 'English' : 'اردو' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('language.switch', 'ur') }}">اردو</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
