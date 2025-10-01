@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
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
                
                <!-- User's Meal Plans -->
                @if(isset($mealPlans) && count($mealPlans) > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ __('Your Meal Plans') }}</h5>
                                <a href="{{ route('mealplanner.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle"></i> {{ __('Add New') }}
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Day') }}</th>
                                                <th>{{ __('Recipes') }}</th>
                                                <th>{{ __('End Date') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mealPlans as $mealPlan)
                                            <tr>
                                                <td>{{ $mealPlan->day }}</td>
                                                <td>
                                                    @if(count($mealPlan->recipes) > 0)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($mealPlan->recipes->take(2) as $recipe)
                                                                <li><i class="bi bi-check-circle-fill text-success me-1"></i> {{ $recipe->title }}</li>
                                                            @endforeach
                                                            @if(count($mealPlan->recipes) > 2)
                                                                <li class="text-muted"><small>+ {{ count($mealPlan->recipes) - 2 }} more</small></li>
                                                            @endif
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">{{ __('No recipes added') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($mealPlan->end_date)
                                                        {{ \Carbon\Carbon::parse($mealPlan->end_date)->format('M d, Y') }}
                                                        @if(\Carbon\Carbon::parse($mealPlan->end_date)->isPast())
                                                            <span class="badge bg-danger ms-2">{{ __('Expired') }}</span>
                                                        @elseif(\Carbon\Carbon::parse($mealPlan->end_date)->diffInDays(now()) < 3)
                                                            <span class="badge bg-warning ms-2">{{ __('Ending Soon') }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">{{ __('No end date') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('mealplanner.edit', $mealPlan->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <a href="{{ route('mealplanner.show', $mealPlan->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </div>
                                                </td>
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
                
                <!-- User's Pantry Items -->
                @if(isset($pantryItems) && count($pantryItems) > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ __('Pantry Items Expiring Soon') }}</h5>
                                <a href="{{ route('pantry.index') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-basket"></i> {{ __('Manage Pantry') }}
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Item') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pantryItems as $item)
                                            <tr class="{{ \Carbon\Carbon::parse($item->expiry_date)->isPast() ? 'table-danger' : (\Carbon\Carbon::parse($item->expiry_date)->diffInDays(now()) < 3 ? 'table-warning' : '') }}">
                                                <td>{{ $item->ingredient->name }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('M d, Y') }}
                                                    @if(\Carbon\Carbon::parse($item->expiry_date)->isPast())
                                                        <span class="badge bg-danger ms-2">{{ __('Expired') }}</span>
                                                    @elseif(\Carbon\Carbon::parse($item->expiry_date)->diffInDays(now()) < 3)
                                                        <span class="badge bg-warning ms-2">{{ __('Soon') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('pantry.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>
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
            @endif
        </div>
    </div>
@endsection