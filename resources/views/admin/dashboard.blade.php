@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="mb-4">{{ __('Welcome to the admin dashboard!') }}</h1>
        
        <!-- Admin Navigation Links -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4 mb-4">
            <!-- User Management -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('User Management') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('Manage user accounts and permissions') }}</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-dark">
                            {{ __('Manage Users') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recipe Management -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Recipe Management') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('Manage recipes and their content') }}</p>
                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-dark">
                            {{ __('Manage Recipes') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Category Management -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Category Management') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('Manage recipe categories') }}</p>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">
                            {{ __('Manage Categories') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Ingredient Management -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Ingredient Management') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('Manage recipe ingredients') }}</p>
                        <a href="{{ route('admin.ingredients.index') }}" class="btn btn-dark">
                            {{ __('Manage Ingredients') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Meal Plan Management -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Meal Plan Management') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('Manage meal plans') }}</p>
                        <a href="{{ route('admin.meal-plans.index') }}" class="btn btn-dark">
                            {{ __('Manage Meal Plans') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Analytics -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Analytics') }}</h5>
                        <p class="card-text text-muted mb-3">{{ __('View site analytics and reports') }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.analytics.top-recipes.view') }}" class="text-primary">{{ __('Top Recipes') }}</a>
                            <a href="{{ route('admin.analytics.ingredient-usage.view') }}" class="text-primary">{{ __('Ingredient Usage') }}</a>
                            <a href="{{ route('admin.analytics.search-trends.view') }}" class="text-primary">{{ __('Search Trends') }}</a>
                            <a href="{{ route('admin.analytics.active-users.view') }}" class="text-primary">{{ __('Active Users') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Analytics Charts Section -->
        <div class="mt-5">
            <h3 class="mb-4">{{ __('Analytics Overview') }}</h3>
            
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <!-- Top Recipes Chart -->
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Top Recipes') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="topRecipesChart"></canvas>
                            </div>
                        </div>
                    </div>
                
                <!-- Ingredient Usage Chart -->
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Ingredient Usage') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="ingredientUsageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Expiring Pantry Chart -->
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Expiring Pantry Items') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="expiringPantryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Search Trends Chart -->
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Search Trends') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="searchTrendsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Users Chart -->
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Active Users') }}</h5>
                            <div style="height: 300px;">
                                <canvas id="activeUsersChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Handle potential errors for each chart
    const createChart = (elementId, fetchUrl, chartType, dataMapper) => {
        const canvas = document.getElementById(elementId);
        if (!canvas) return;
        
        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    new Chart(canvas, dataMapper(data, chartType));
                }
            })
            .catch(err => {
                console.error(`Error loading chart ${elementId}:`, err);
            });
    };
    
    // 1. Top Recipes
    createChart('topRecipesChart', '/admin/analytics/top-recipes', 'bar', (data, type) => ({
        type: type,
        data: {
            labels: data.map(r => r.name),
            datasets: [{
                label: 'Views',
                data: data.map(r => r.views),
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    }));

    // 2. Ingredient Usage
    createChart('ingredientUsageChart', '/admin/analytics/ingredient-usage', 'pie', (data, type) => ({
        type: type,
        data: {
            labels: data.map(i => i.name),
            datasets: [{
                label: 'Usage',
                data: data.map(i => i.usage_count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ]
            }]
        }
    }));

    // 3. Expiring Pantry
    createChart('expiringPantryChart', '/admin/analytics/expiring-pantry', 'bar', (data, type) => ({
        type: type,
        data: {
            labels: data.map(i => i.name),
            datasets: [{
                label: 'Expiry in Days',
                data: data.map(i => Math.ceil((new Date(i.expiry_date) - new Date()) / (1000*60*60*24))),
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        }
    }));

    // 4. Search Trends
    createChart('searchTrendsChart', '/admin/analytics/search-trends', 'line', (data, type) => ({
        type: type,
        data: {
            labels: data.map(s => s.date),
            datasets: [{
                label: 'Searches',
                data: data.map(s => s.searches),
                borderColor: 'rgba(54, 162, 235, 0.9)',
                fill: false
            }]
        }
    }));

    // 5. Active Users
    createChart('activeUsersChart', '/admin/analytics/active-users', 'line', (data, type) => ({
        type: type,
        data: {
            labels: data.map(u => u.date),
            datasets: [{
                label: 'Active Users',
                data: data.map(u => u.active_users),
                borderColor: 'rgba(75, 192, 192, 0.9)',
                fill: false
            }]
        }
    }));
});
</script>
                </div>
            </div>
        </div>
    </div>
@endsection
