<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-4 fw-semibold text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(auth()->user()->role === 'admin')
                <!-- Admin Dashboard Content -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Recipe Management') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Manage recipes and their content') }}</p>
                                <a href="{{ route('admin.recipes.index') }}" class="btn btn-primary">
                                    {{ __('Manage Recipes') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('User Management') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Manage user accounts') }}</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                    {{ __('Manage Users') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Analytics') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('View site analytics and statistics') }}</p>
                                <a href="{{ route('admin.analytics.top-recipes') }}" class="btn btn-primary">
                                    {{ __('View Analytics') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Admin Panel') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Go to full admin dashboard') }}</p>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                    {{ __('Admin Dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(isset($topRecipes) && $topRecipes->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">{{ __('Top Recipes') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Views') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topRecipes as $recipe)
                                            <tr>
                                                <td>{{ $recipe->title }}</td>
                                                <td>{{ $recipe->views_count }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Regular User Dashboard Content -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-4">
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('My Recipes') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Browse your favorite recipes') }}</p>
                                <a href="{{ route('favorites.index') }}" class="btn btn-primary">
                                    {{ __('View Favorites') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Meal Planner') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Plan your meals for the week') }}</p>
                                <a href="{{ route('mealplanner.index') }}" class="btn btn-primary">
                                    {{ __('View Meal Plans') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('My Profile') }}</h5>
                                <p class="card-text text-muted mb-3">{{ __('Update your profile information') }}</p>
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    {{ __('Edit Profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
